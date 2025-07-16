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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('is_active');
            $table->unsignedBigInteger('approved_by')->nullable()->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->string('employee_id')->nullable()->after('phone');
            $table->string('department')->nullable()->after('employee_id');
            $table->string('position')->nullable()->after('department');
            $table->string('avatar')->nullable()->after('position');
            $table->integer('login_attempts')->default(0)->after('last_login_at');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
            $table->timestamp('password_changed_at')->nullable()->after('locked_until');
            $table->softDeletes();
            
            // Add foreign key constraint
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // Add indexes
            $table->index(['role', 'is_active']);
            $table->index(['is_approved', 'is_active']);
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['role', 'is_active']);
            $table->dropIndex(['is_approved', 'is_active']);
            $table->dropIndex(['employee_id']);
            
            $table->dropColumn([
                'is_approved',
                'approved_by',
                'approved_at',
                'employee_id',
                'department',
                'position',
                'avatar',
                'login_attempts',
                'locked_until',
                'password_changed_at',
                'deleted_at',
            ]);
        });
    }
};
