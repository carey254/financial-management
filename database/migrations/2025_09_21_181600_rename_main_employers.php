<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // No-op: legacy employer rename logic removed. Intentionally left blank to keep migration history clean.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: nothing to revert.
    }
};
