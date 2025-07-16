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
        Schema::create('user_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('request_type'); // registration, role_change, activation, etc.
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('request_data')->nullable(); // Data yang direquest
            $table->text('reason')->nullable(); // Alasan request
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('approval_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['request_type', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_approval_requests');
    }
};
