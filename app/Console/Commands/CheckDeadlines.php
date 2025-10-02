<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineReminder;
use Carbon\Carbon;

class CheckDeadlines extends Command
{
    protected $signature = 'tasks:send-deadline-reminders';

    protected $description = 'Send email reminders for tasks due in about 24 hours';

    public function handle(): int
    {
        $now = Carbon::now();
        // Window around 24 hours to avoid missing exact minute, matching a 15-min scheduler
        $from = $now->copy()->addDay()->subMinutes(15);
        $to = $now->copy()->addDay()->addMinutes(15);

        $tasks = Task::with('user')
            ->where('status', 'pending')
            ->whereNotNull('deadline')
            ->whereNull('deadline_reminder_sent_at')
            ->whereBetween('deadline', [$from, $to])
            ->get();

        $sent = 0;

        foreach ($tasks as $task) {
            $user = $task->user;
            if (!$user || empty($user->email)) {
                continue;
            }

            try {
                $user->notify(new TaskDeadlineReminder($task));
                $task->forceFill(['deadline_reminder_sent_at' => Carbon::now()])->save();
                $sent++;
            } catch (\Throwable $e) {
                $this->error('Failed to notify for task ID ' . $task->id . ': ' . $e->getMessage());
            }
        }

        $this->info("Deadline reminders sent: {$sent}");
        return self::SUCCESS;
    }
}
