<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('last_name')->nullable()->after('name');
            $table->string('phone', 20)->nullable()->after('email');
            $table->enum('gender', ['male', 'female'])->nullable()->after('phone');
            $table->string('marital_status')->nullable()->after('gender');

            $table->date('date_of_birth')->nullable()->after('marital_status');
            $table->date('date_of_joining')->nullable()->after('date_of_birth');

            $table->string('permanent_address')->nullable()->after('address');

            $table->text('qualification')->nullable()->after('permanent_address');
            $table->text('work_experience')->nullable()->after('qualification');
            $table->text('note')->nullable()->after('work_experience');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'last_name',
                'phone',
                'gender',
                'marital_status',
                'date_of_birth',
                'date_of_joining',
                'permanent_address',
                'qualification',
                'work_experience',
                'note',
                'created_by_id',
                'is_admin',
            ]);
        });
    }
};
