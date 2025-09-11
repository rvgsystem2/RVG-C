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
        Schema::table('packages', function (Blueprint $table) {
          $table->foreignId('package_category_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('package_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
         $table->dropForeign(['package_category_id']);
            $table->dropColumn('package_category_id');
        });
    }
};
