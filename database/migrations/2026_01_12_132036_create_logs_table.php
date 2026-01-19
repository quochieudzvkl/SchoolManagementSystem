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
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->index();
            $table->tinyInteger('role')->nullable()->comment('1:SuperAdmin,2:Admin,3:School,4:SchoolAdmin,5:Teacher,6:Student,7:Parent');
            $table->string('action');
            // login | logout | register | verify_email | failed_login
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_success')->default(true);
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
