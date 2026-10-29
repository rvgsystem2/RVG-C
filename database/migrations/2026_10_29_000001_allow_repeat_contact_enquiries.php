<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ContactController accepts phone-only enquiries. A contact email is not an account identifier.
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('email')->nullable()->change();
        });
        Schema::table('contacts', fn (Blueprint $table) => $table->index('email'));
    }

    public function down(): void
    {
        // Preserve enquiries. Restoring the original NOT NULL/UNIQUE constraint is only
        // safe after an operator resolves null and duplicate email addresses.
        if (\Illuminate\Support\Facades\DB::table('contacts')->whereNull('email')->exists()
            || \Illuminate\Support\Facades\DB::table('contacts')->select('email')->groupBy('email')->havingRaw('COUNT(*) > 1')->exists()) {
            throw new RuntimeException('Resolve null/duplicate contact emails before rolling back this migration.');
        }
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->string('email')->nullable(false)->change();
            $table->unique('email');
        });
    }
};
