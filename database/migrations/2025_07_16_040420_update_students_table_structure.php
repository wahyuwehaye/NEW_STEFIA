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
        Schema::table('students', function (Blueprint $table) {
            // Add new fields
            if (!Schema::hasColumn('students', 'major_id')) {
                $table->foreignId('major_id')->nullable()->after('department')->constrained('majors')->onDelete('set null');
            }
            if (!Schema::hasColumn('students', 'academic_year_id')) {
                $table->foreignId('academic_year_id')->nullable()->after('major_id')->constrained('academic_years')->onDelete('set null');
            }
            if (!Schema::hasColumn('students', 'semester_menunggak')) {
                $table->integer('semester_menunggak')->default(0)->after('academic_year_id');
            }
            
            // Note: student_id already exists, nim also exists - no need to rename
            
            // We'll keep parent fields for now to maintain backward compatibility
            
            // Add indexes
            if (!Schema::hasColumn('students', 'major_id')) {
                $table->index('major_id');
            }
            if (!Schema::hasColumn('students', 'academic_year_id')) {
                $table->index('academic_year_id');
            }
            if (!Schema::hasColumn('students', 'semester_menunggak')) {
                $table->index('semester_menunggak');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
