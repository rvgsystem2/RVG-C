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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Job Title
            $table->text('description')->nullable(); // Job Description
            $table->string('location')->nullable(); // eg. Remote / Mumbai
            $table->string('experience')->nullable(); // eg. 2+ years
            $table->enum('type', ['Full Time', 'Part Time', 'Internship', 'Contract'])->default('Full Time');
            $table->date('valid_through')->nullable(); // Application deadline
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
