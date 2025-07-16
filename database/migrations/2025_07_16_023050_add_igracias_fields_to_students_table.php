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
            // iGracias integration fields
            $table->string('nim')->nullable()->after('student_id');
            $table->string('external_id')->nullable()->after('nim');
            $table->string('birth_place')->nullable()->after('birth_date');
            $table->string('faculty')->nullable()->after('program_study');
            $table->string('department')->nullable()->after('faculty');
            $table->string('cohort_year')->nullable()->after('academic_year');
            $table->integer('current_semester')->nullable()->after('cohort_year');
            $table->integer('outstanding_semesters')->default(0)->after('outstanding_amount');
            $table->date('last_payment_date')->nullable()->after('outstanding_semesters');
            $table->boolean('is_reminded')->default(false)->after('last_payment_date');
            $table->datetime('last_sync_at')->nullable()->after('is_reminded');
            
            // Parent information
            $table->string('father_name')->nullable()->after('parent_name');
            $table->string('father_phone')->nullable()->after('father_name');
            $table->string('father_occupation')->nullable()->after('father_phone');
            $table->text('father_address')->nullable()->after('father_occupation');
            $table->string('mother_name')->nullable()->after('father_address');
            $table->string('mother_phone')->nullable()->after('mother_name');
            $table->string('mother_occupation')->nullable()->after('mother_phone');
            $table->text('mother_address')->nullable()->after('mother_occupation');
            
            // Indexes
            $table->index(['nim']);
            $table->index(['external_id']);
            $table->index(['faculty', 'department']);
            $table->index(['cohort_year']);
            $table->index(['outstanding_semesters']);
            $table->index(['last_sync_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['nim']);
            $table->dropIndex(['external_id']);
            $table->dropIndex(['faculty', 'department']);
            $table->dropIndex(['cohort_year']);
            $table->dropIndex(['outstanding_semesters']);
            $table->dropIndex(['last_sync_at']);
            
            $table->dropColumn([
                'nim', 'external_id', 'birth_place', 'faculty', 'department',
                'cohort_year', 'current_semester', 'outstanding_semesters',
                'last_payment_date', 'is_reminded', 'last_sync_at',
                'father_name', 'father_phone', 'father_occupation', 'father_address',
                'mother_name', 'mother_phone', 'mother_occupation', 'mother_address'
            ]);
        });
    }
};
