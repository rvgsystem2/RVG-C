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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('label');                 
            $table->string('name');
              $table->string('short_description', 300)->nullable();
            $table->text('description')->nullable();
            $table->string('price');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedInteger('duration_days')->nullable(); // validity
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('thumbnail')->nullable(); // image path
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
