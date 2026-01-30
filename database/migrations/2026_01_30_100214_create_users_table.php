<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));

            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('username', 50)->unique();
            $table->string('password');

            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestampTz('last_login_at')->nullable();

            $table->timestampsTz(); // creates created_at and updated_at with timezone
            $table->softDeletesTz(); // creates deleted_at with timezone

            // Indexes
            $table->index('fullname', 'idx_users_fullname');
            $table->index('email', 'idx_users_email');
            $table->index('username', 'idx_users_username');
            $table->index('is_active', 'idx_users_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
