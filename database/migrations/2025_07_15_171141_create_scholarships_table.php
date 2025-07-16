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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('scholarship_code')->unique(); // Kode beasiswa
            $table->string('name'); // Nama beasiswa
            $table->text('description')->nullable(); // Deskripsi beasiswa
            $table->enum('type', ['academic', 'achievement', 'financial_need', 'sports', 'arts', 'research', 'other'])->default('academic');
            $table->decimal('amount', 15, 2); // Jumlah beasiswa
            $table->enum('amount_type', ['fixed', 'percentage'])->default('fixed'); // Jenis jumlah (tetap atau persentase)
            $table->decimal('percentage', 5, 2)->nullable(); // Persentase jika amount_type = percentage
            $table->string('academic_year'); // Tahun ajaran
            $table->integer('quota')->default(1); // Kuota penerima
            $table->integer('recipients_count')->default(0); // Jumlah penerima saat ini
            $table->date('application_start_date'); // Tanggal mulai pendaftaran
            $table->date('application_end_date'); // Tanggal berakhir pendaftaran
            $table->date('announcement_date')->nullable(); // Tanggal pengumuman
            $table->enum('status', ['draft', 'open', 'closed', 'announced', 'cancelled'])->default('draft');
            $table->json('requirements')->nullable(); // Persyaratan dalam JSON
            $table->json('criteria')->nullable(); // Kriteria penilaian dalam JSON
            $table->text('terms_and_conditions')->nullable(); // Syarat dan ketentuan
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->foreignId('created_by')->constrained('users'); // User yang membuat beasiswa
            $table->timestamps();
            
            // Indexes
            $table->index(['scholarship_code']);
            $table->index(['type']);
            $table->index(['academic_year']);
            $table->index(['status']);
            $table->index(['application_start_date']);
            $table->index(['application_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
