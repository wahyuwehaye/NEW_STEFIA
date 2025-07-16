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
        // Check if billing_actions table exists
        if (Schema::hasTable('billing_actions')) {
            // Table exists, check if we need to update debt_id column
            Schema::table('billing_actions', function (Blueprint $table) {
                // Check if we need to rename receivable_id to debt_id
                if (Schema::hasColumn('billing_actions', 'receivable_id') && !Schema::hasColumn('billing_actions', 'debt_id')) {
                    $table->renameColumn('receivable_id', 'debt_id');
                }
            });
        } else {
            // Create new table
            Schema::create('billing_actions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('debt_id');
                $table->enum('action_type', ['nde_fakultas', 'dosen_wali', 'surat_orangtua', 'telepon', 'home_visit']);
                $table->text('description')->nullable();
                $table->date('action_date');
                $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                
                // Indexes
                $table->index('debt_id');
                $table->index('action_type');
                $table->index('action_date');
                $table->index('performed_by');
            });
            
            // Add foreign key constraint if debts table exists
            if (Schema::hasTable('debts')) {
                Schema::table('billing_actions', function (Blueprint $table) {
                    $table->foreign('debt_id')->references('id')->on('debts')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_actions');
    }
};
