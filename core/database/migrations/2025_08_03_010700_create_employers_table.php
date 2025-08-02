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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();

            // Auth
            $table->string('email')->unique();
            $table->string('user_name')->nullable()->unique();
            $table->string('password'); // Password field
            $table->timestamp('email_verified_at')->nullable(); // Email verification
            $table->rememberToken(); // For "remember me" feature

            // Company Info
            $table->string('company_name');
            $table->string('industry')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->text('company_description')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_country')->default('Bangladesh');

            // Representative Info
            $table->string('representative_name');
            $table->string('representative_designation')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('representative_phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
