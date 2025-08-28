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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employer');
            $table->text('task_description');
            $table->integer('pages');
            $table->decimal('rate', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'employer']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
