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
            $table->unsignedBigInteger('receivable_id')->nullable()->after('user_id');
            $table->enum('source', ['manual', 'igracias'])->default('manual')->after('verified_by');
            $table->string('igracias_id')->nullable()->after('source');
            $table->json('igracias_data')->nullable()->after('igracias_id');
            $table->boolean('auto_applied')->default(false)->after('igracias_data');
            
            $table->foreign('receivable_id')->references('id')->on('receivables')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['receivable_id']);
            $table->dropColumn([
                'receivable_id',
                'source',
                'igracias_id', 
                'igracias_data',
                'auto_applied'
            ]);
        });
    }
};
