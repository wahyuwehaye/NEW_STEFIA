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
        Schema::table('payments', function (Blueprint $table) {
            // Add new fields
            if (!Schema::hasColumn('payments', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('payment_date')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('payments', 'external_ref')) {
                $table->string('external_ref', 100)->nullable()->after('verified_by');
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'transfer', 'online', 'other'])->default('cash')->after('external_ref');
            }
            
            // Add indexes
            if (!Schema::hasColumn('payments', 'verified_by')) {
                $table->index('verified_by');
            }
            if (!Schema::hasColumn('payments', 'external_ref')) {
                $table->index('external_ref');
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->index('payment_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
