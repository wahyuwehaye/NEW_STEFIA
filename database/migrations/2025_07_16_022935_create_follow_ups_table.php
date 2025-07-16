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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('receivable_id')->nullable();
            $table->enum('action_type', ['nde_fakultas', 'dosen_wali', 'surat_orangtua', 'telepon', 'home_visit', 'other']);
            $table->string('title');
            $table->text('description');
            $table->date('action_date');
            $table->unsignedBigInteger('performed_by');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('result')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('receivable_id')->references('id')->on('receivables')->onDelete('set null');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'action_type']);
            $table->index(['action_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
