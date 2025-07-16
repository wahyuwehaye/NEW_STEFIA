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
        // First rename receivables table to debts if it exists
        if (Schema::hasTable('receivables') && !Schema::hasTable('debts')) {
            Schema::rename('receivables', 'debts');
        }
        
        // Ensure debts table exists
        if (!Schema::hasTable('debts')) {
            Schema::create('debts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->foreignId('fee_id')->constrained('fees')->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
                $table->date('due_date');
                $table->timestamps();
                
                // Indexes
                $table->index('student_id');
                $table->index('fee_id');
                $table->index('status');
                $table->index('due_date');
            });
        }
        
        // Add new fields to debts table
        Schema::table('debts', function (Blueprint $table) {
            // Check if semester column doesn't exist
            if (!Schema::hasColumn('debts', 'semester')) {
                $table->integer('semester')->after('due_date');
            }
            
            // Check if academic_year_id column doesn't exist
            if (!Schema::hasColumn('debts', 'academic_year_id')) {
                $table->foreignId('academic_year_id')->nullable()->after('semester')->constrained('academic_years')->onDelete('set null');
            }
            
            // Add indexes if they don't exist
            if (!Schema::hasColumn('debts', 'semester')) {
                $table->index('semester');
            }
            if (!Schema::hasColumn('debts', 'academic_year_id')) {
                $table->index('academic_year_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('debts', function (Blueprint $table) {
            //
        });
    }
};
