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
        // Skip - payments table doesn't have receivable_id column
        // The table already has proper structure
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
