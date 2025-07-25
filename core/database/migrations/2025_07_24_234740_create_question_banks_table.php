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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., 45th BCS
            $table->year('year')->nullable();
            $table->foreignId('created_by')->constrained('admins')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->tinyInteger('status')->default(1)->comment('1=> Active, 0=> Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_banks');
    }
};
