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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('item');
            $table->decimal('amount', 10, 2);
            $table->enum('category', ['Bills', 'Wants', 'Savings', 'Debts']);
            $table->boolean('necessary')->default(true);
            $table->enum('status', ['paid', 'pending'])->default('paid');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'category']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
