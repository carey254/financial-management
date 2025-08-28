<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('employer_id')->nullable()->constrained()->onDelete('cascade');
            $table->index('employer_id');
        });
        
        // Migrate existing tasks to use employer_id instead of employer string
        $this->migrateExistingTasks();
    }
    
    /**
     * Migrate existing tasks to use employer relationships
     */
    private function migrateExistingTasks()
    {
        $tasks = \DB::table('tasks')->whereNotNull('employer')->get();
        
        foreach ($tasks as $task) {
            // Find the employer record for this task's user
            $employer = \DB::table('employers')
                ->where('user_id', $task->user_id)
                ->where('name', $task->employer)
                ->first();
                
            if ($employer) {
                \DB::table('tasks')
                    ->where('id', $task->id)
                    ->update(['employer_id' => $employer->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['employer_id']);
            $table->dropColumn('employer_id');
        });
    }
};
