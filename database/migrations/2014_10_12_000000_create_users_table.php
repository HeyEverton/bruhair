<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', [
                \App\Enums\UserRole::ADMIN->value,
                \App\Enums\UserRole::CUSTOMER->value,
                \App\Enums\UserRole::EMPLOYEE->value,
            ]);
            $table->string('phone_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('employee_code')->nullable();
            $table->datetime('last_visit')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
