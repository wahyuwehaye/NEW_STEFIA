<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the gender column to include 'other' option
        DB::statement("ALTER TABLE students MODIFY COLUMN gender ENUM('male', 'female', 'other') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE students MODIFY COLUMN gender ENUM('male', 'female') NULL");
    }
};
