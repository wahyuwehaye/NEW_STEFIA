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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // NIM atau ID siswa
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('class')->nullable(); // Kelas
            $table->string('program_study')->nullable(); // Program studi
            $table->string('academic_year'); // Tahun ajaran
            $table->enum('status', ['active', 'inactive', 'graduated', 'dropped_out'])->default('active');
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->decimal('total_fee', 15, 2)->default(0); // Total biaya
            $table->decimal('paid_amount', 15, 2)->default(0); // Jumlah yang sudah dibayar
            $table->decimal('outstanding_amount', 15, 2)->default(0); // Sisa tunggakan
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->timestamps();
            
            // Indexes
            $table->index(['student_id']);
            $table->index(['status']);
            $table->index(['academic_year']);
            $table->index(['class']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
