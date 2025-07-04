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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            // Basic SEO Fields
            $table->string('title')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('robots')->nullable();

            // Open Graph (OG) Tags
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_url')->nullable();

            // Twitter Card Tags
            $table->string('twitter_card')->nullable();
            $table->string('twitter_title')->nullable();
            $table->string('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();

            // Schema / Structured Data
            $table->string('schema_type')->nullable();
            $table->text('schema_data')->nullable();
            $table->text('structured_data_json')->nullable(); // Full JSON-LD

            // Focused SEO Optimization Fields
            $table->string('focus_keyword')->nullable();
            $table->text('meta_tags')->nullable(); // Additional meta tags


            // Alternate (hreflang/multilingual)
            $table->string('alternate_href_lang')->nullable();
            $table->string('alternate_country')->nullable();
            $table->string('alternate_url')->nullable();

            // Breadcrumb & Content Info
            $table->string('breadcrumb_title')->nullable();
            $table->string('content_type')->nullable(); // article, profile, product
            $table->string('author')->nullable();
          

            // Sitemap Support
            $table->string('priority')->nullable(); // 0.1 to 1.0
            $table->string('changefreq')->nullable(); // daily, weekly, monthly

            // Page Info
            $table->string('page_type')->nullable(); // home, about, service, etc.
           $table->string('locale')->nullable();
            $table->string('country')->default('India');
            $table->string('region')->nullable();
            $table->string('timezone')->default('UTC');

            // Optional Foreign Keys
            $table->foreignId('blog_id')->nullable()->constrained('blogs')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('service_details')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
