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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code')->unique(); // Kode pembayaran
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang mencatat pembayaran
            $table->decimal('amount', 15, 2); // Jumlah pembayaran
            $table->date('payment_date'); // Tanggal pembayaran
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'debit_card', 'e_wallet', 'other'])->default('cash');
            $table->enum('payment_type', ['tuition', 'registration', 'exam', 'library', 'laboratory', 'other'])->default('tuition');
            $table->string('reference_number')->nullable(); // Nomor referensi (untuk transfer bank, dll)
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->text('description')->nullable(); // Deskripsi pembayaran
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->string('receipt_number')->nullable(); // Nomor kwitansi
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->timestamp('verified_at')->nullable(); // Waktu verifikasi
            $table->foreignId('verified_by')->nullable()->constrained('users'); // User yang verifikasi
            $table->timestamps();
            
            // Indexes
            $table->index(['student_id']);
            $table->index(['payment_date']);
            $table->index(['status']);
            $table->index(['payment_method']);
            $table->index(['payment_type']);
            $table->index(['payment_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
