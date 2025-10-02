<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $deadline = optional($this->task->deadline)->timezone(config('app.timezone'));

        $subject = '[URGENT] Task deadline in 24 hours';

        $mail = (new MailMessage)
            ->from(config('mail.from.address'), 'OBADIAH WEB')
            ->subject($subject)
            ->greeting('Hello ' . ($notifiable->name ?? 'there'))
            ->line('URGENT: A task is approaching its deadline in approximately 24 hours:')
            ->line('Task: ' . $this->task->task_description)
            ->line('Employer: ' . $this->task->employer)
            ->line('Pages: ' . number_format($this->task->pages))
            ->line('Amount: KSH ' . number_format($this->task->amount, 2))
            ->line('Status: ' . ucfirst($this->task->status))
            ->line('Deadline: ' . ($deadline ? $deadline->format('M d, Y g:i A') : 'N/A'))
            ->action('View Tasks', route('tasks.index'))
            ->line('If you have already handled this, you can ignore this message.');

        // CC the secondary email only if it's different from the user's registered email to avoid duplicates
        $secondary = 'kipronoobadiah6934@gmail.com';
        $primary = $notifiable->email ?? '';
        if (strcasecmp($primary, $secondary) !== 0) {
            $mail->cc($secondary);
        }

        return $mail;
    }
}
