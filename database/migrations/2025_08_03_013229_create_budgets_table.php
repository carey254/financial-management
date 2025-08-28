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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['Bills', 'Wants', 'Savings', 'Debts']);
            $table->string('item');
            $table->decimal('budgeted_amount', 10, 2);
            $table->decimal('actual_amount', 10, 2)->default(0);
            $table->integer('month');
            $table->integer('year');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'month', 'year']);
            $table->index(['user_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
