<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('default_title');
            $table->string('default_description', 320);
            $table->string('keywords', 500)->nullable();
            $table->string('author')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('twitter_site', 50)->nullable();
            $table->string('google_site_verification')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
