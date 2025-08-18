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
        Schema::table('careers', function (Blueprint $table) {
        $table->integer('salary_min')->nullable();     
        $table->integer('salary_max')->nullable();     
        $table->string('salary_currency', 3)->default('INR');
        $table->enum('salary_unit', ['HOUR','DAY','WEEK','MONTH','YEAR'])->default('MONTH');
        $table->string('street_address')->nullable();  
        $table->string('region')->nullable()->default('Uttar Pradesh');
        $table->string('postal_code')->nullable()->default('208024');
        $table->string('country')->nullable()->default('IN');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('careers', function (Blueprint $table) {
             $table->dropColumn([
            'salary_min',
            'salary_max',
            'salary_currency',
            'salary_unit',
            'street_address',
            'region',
            'postal_code',
            'country',
        ]);
        });
    }
};
