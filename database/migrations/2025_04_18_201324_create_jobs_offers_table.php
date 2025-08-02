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
        Schema::create('jobs_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('education_id')->constrained('educations')->cascadeOnDelete();

            $table->string('job_title');
            $table->decimal('salary', 10, 2)->nullable();
            $table->unsignedInteger('experience')->default(1);
            $table->unsignedInteger('age')->default(1);
            $table->enum('job_type', ['full-time', 'part-time', 'internship'])->default('full-time');
            $table->enum('gender', ['male', 'female', 'none'])->default('none');
            $table->enum('job_level', ['junior', 'middle', 'senior'])->default('junior');
            $table->date('application_deadline')->nullable();
            $table->text('requirements')->nullable();
            $table->unsignedInteger('skills_weight')->default(1);
            $table->unsignedInteger('education_weight')->default(1);
            $table->unsignedInteger('experience_weight')->default(1);
            $table->unsignedInteger('lang_weight')->default(1);
            
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
