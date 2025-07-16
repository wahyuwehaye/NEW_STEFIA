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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_code')->unique(); // Kode biaya
            $table->string('name'); // Nama biaya
            $table->text('description')->nullable(); // Deskripsi biaya
            $table->enum('type', ['tuition', 'registration', 'exam', 'library', 'laboratory', 'uniform', 'book', 'activity', 'other'])->default('tuition');
            $table->decimal('amount', 15, 2); // Jumlah biaya
            $table->enum('frequency', ['one_time', 'monthly', 'quarterly', 'semester', 'annual'])->default('one_time');
            $table->string('academic_year'); // Tahun ajaran
            $table->string('applicable_class')->nullable(); // Kelas yang berlaku (nullable = semua kelas)
            $table->string('applicable_program')->nullable(); // Program studi yang berlaku (nullable = semua program)
            $table->date('effective_date'); // Tanggal berlaku
            $table->date('expiry_date')->nullable(); // Tanggal berakhir
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->boolean('is_mandatory')->default(true); // Apakah wajib dibayar
            $table->decimal('penalty_rate', 5, 2)->default(0); // Persentase denda per hari
            $table->integer('grace_period_days')->default(0); // Masa tenggang (hari)
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->foreignId('created_by')->constrained('users'); // User yang membuat biaya
            $table->timestamps();
            
            // Indexes
            $table->index(['fee_code']);
            $table->index(['type']);
            $table->index(['academic_year']);
            $table->index(['status']);
            $table->index(['effective_date']);
            $table->index(['applicable_class']);
            $table->index(['applicable_program']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
