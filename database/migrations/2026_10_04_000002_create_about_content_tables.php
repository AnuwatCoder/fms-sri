<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->default('เกี่ยวกับหน่วยงาน');
            $table->string('meta_description')->nullable();
            $table->string('hero_eyebrow')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('intro_eyebrow')->nullable();
            $table->string('intro_heading');
            $table->text('intro_paragraph_1')->nullable();
            $table->text('intro_paragraph_2')->nullable();
            $table->string('image_path')->nullable();
            $table->string('responsibilities_eyebrow')->nullable();
            $table->string('responsibilities_title')->nullable();
            $table->string('responsibilities_description')->nullable();
            $table->string('personnel_eyebrow')->nullable();
            $table->string('personnel_title')->nullable();
            $table->string('personnel_description')->nullable();
            $table->timestamps();
        });

        Schema::create('about_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->default('bi-check-circle-fill');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('position_th')->nullable();
            $table->string('position_en')->nullable();
            $table->string('unit')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('initials', 10)->nullable();
            $table->string('photo_path')->nullable();
            $table->string('color', 30)->default('blue');
            $table->boolean('is_head')->default(false);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnel');
        Schema::dropIfExists('about_responsibilities');
        Schema::dropIfExists('about_pages');
    }
};
