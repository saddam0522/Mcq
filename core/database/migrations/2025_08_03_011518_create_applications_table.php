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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'rejected', 'shortlisted'])->default('pending');
            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();
        });

        // Update users table to add CV column
        Schema::table('users', function (Blueprint $table) {
            $table->string('cv')->nullable()->after('email'); // or 'after' any other field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
        
        // Remove cv column from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cv');
        });
    }
};
