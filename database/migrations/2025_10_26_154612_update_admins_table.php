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
        Schema::table('admins', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('admins', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('admins', 'email')) {
                $table->string('email')->unique()->after('name');
            }
            if (!Schema::hasColumn('admins', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (!Schema::hasColumn('admins', 'password')) {
                $table->string('password')->after('email_verified_at');
            }
            if (!Schema::hasColumn('admins', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
            if (!Schema::hasColumn('admins', 'role')) {
                $table->string('role')->default('admin')->after('is_active');
            }
            if (!Schema::hasColumn('admins', 'remember_token')) {
                $table->rememberToken()->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
};
