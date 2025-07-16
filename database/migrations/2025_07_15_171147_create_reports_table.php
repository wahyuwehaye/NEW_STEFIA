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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code')->unique(); // Kode laporan
            $table->string('title'); // Judul laporan
            $table->text('description')->nullable(); // Deskripsi laporan
            $table->enum('type', ['payment', 'receivable', 'student', 'fee', 'scholarship', 'financial', 'custom'])->default('payment');
            $table->enum('format', ['pdf', 'excel', 'csv', 'json'])->default('pdf');
            $table->json('parameters')->nullable(); // Parameter laporan dalam JSON
            $table->json('filters')->nullable(); // Filter yang digunakan dalam JSON
            $table->date('period_start')->nullable(); // Tanggal mulai periode
            $table->date('period_end')->nullable(); // Tanggal akhir periode
            $table->enum('status', ['draft', 'generating', 'completed', 'failed', 'cancelled'])->default('draft');
            $table->string('file_path')->nullable(); // Path file laporan yang dihasilkan
            $table->string('file_name')->nullable(); // Nama file laporan
            $table->bigInteger('file_size')->nullable(); // Ukuran file dalam bytes
            $table->text('error_message')->nullable(); // Pesan error jika gagal
            $table->timestamp('generated_at')->nullable(); // Waktu laporan dihasilkan
            $table->timestamp('expires_at')->nullable(); // Waktu kedaluwarsa file
            $table->integer('download_count')->default(0); // Jumlah download
            $table->timestamp('last_downloaded_at')->nullable(); // Waktu download terakhir
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->foreignId('generated_by')->constrained('users'); // User yang membuat laporan
            $table->timestamps();
            
            // Indexes
            $table->index(['report_code']);
            $table->index(['type']);
            $table->index(['status']);
            $table->index(['generated_at']);
            $table->index(['period_start']);
            $table->index(['period_end']);
            $table->index(['generated_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
