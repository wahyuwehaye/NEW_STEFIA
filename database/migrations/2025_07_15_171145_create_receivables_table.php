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
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->string('receivable_code')->unique(); // Kode piutang
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('fee_id')->nullable()->constrained('fees')->onDelete('set null'); // Terkait dengan biaya tertentu
            $table->decimal('amount', 15, 2); // Jumlah piutang
            $table->decimal('paid_amount', 15, 2)->default(0); // Jumlah yang sudah dibayar
            $table->decimal('outstanding_amount', 15, 2); // Sisa piutang
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->enum('status', ['pending', 'partial', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->text('description')->nullable(); // Deskripsi piutang
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->decimal('penalty_amount', 15, 2)->default(0); // Denda keterlambatan
            $table->date('penalty_date')->nullable(); // Tanggal mulai denda
            $table->json('metadata')->nullable(); // Data tambahan dalam JSON
            $table->foreignId('created_by')->constrained('users'); // User yang membuat piutang
            $table->timestamp('last_reminder_sent')->nullable(); // Waktu pengiriman reminder terakhir
            $table->timestamps();
            
            // Indexes
            $table->index(['student_id']);
            $table->index(['due_date']);
            $table->index(['status']);
            $table->index(['priority']);
            $table->index(['receivable_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
