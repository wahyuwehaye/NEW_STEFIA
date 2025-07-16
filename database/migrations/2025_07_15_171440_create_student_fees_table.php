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
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('fee_id')->constrained('fees')->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Amount dapat berbeda dari fee asli jika ada discount/adjustment
            $table->date('due_date'); // Due date untuk student ini
            $table->enum('status', ['pending', 'paid', 'partial', 'overdue', 'waived'])->default('pending');
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('outstanding_amount', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0); // Discount yang diberikan
            $table->text('discount_reason')->nullable(); // Alasan discount
            $table->foreignId('assigned_by')->constrained('users'); // User yang assign fee ke student
            $table->timestamp('assigned_at'); // Kapan fee di-assign
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['student_id']);
            $table->index(['fee_id']);
            $table->index(['status']);
            $table->index(['due_date']);
            $table->unique(['student_id', 'fee_id']); // Prevent duplicate assignments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
