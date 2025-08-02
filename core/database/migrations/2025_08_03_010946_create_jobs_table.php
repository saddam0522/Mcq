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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->string('location');
            $table->enum('job_type', ['Full Time', 'Part Time', 'Contract', 'Internship'])->default('Full Time');
            $table->enum('work_mode', ['Office', 'Remote', 'Hybrid'])->default('Office');
            $table->integer('experience_required')->default(0)->comment('in years');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('currency', 10)->default('BDT');

            $table->date('published_at');
            $table->date('deadline');

            $table->text('short_description')->nullable();
            $table->text('full_description');

            $table->json('skills')->nullable();
            $table->string('education')->nullable();
            $table->string('gender_preference')->nullable();
            $table->integer('vacancies')->default(1);
            $table->enum('status', ['draft', 'published', 'unpublished'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
