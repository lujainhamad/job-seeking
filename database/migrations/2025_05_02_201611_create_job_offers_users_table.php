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
        Schema::create('job_offers_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_offer_id')->constrained('jobs_offers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('initial_salary')->nullable();
            $table->enum('interview_status',['pending','approved','rejected'])->default('pending');
            $table->boolean('is_approved')->default(0); // For employee is approved in company
            $table->timestamp('interview_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers_users');
    }
};
