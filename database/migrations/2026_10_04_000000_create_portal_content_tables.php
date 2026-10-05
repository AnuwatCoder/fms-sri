<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });

        Schema::create('portal_systems', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->default('bi-grid-fill');
            $table->string('color', 30)->default('blue');
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('group_key', 30)->default('service');
            $table->string('access_type', 20)->default('external');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('news_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('image_path')->nullable();
            $table->string('url')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('portal_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('place')->nullable();
            $table->string('url')->nullable();
            $table->string('color', 30)->default('blue');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('portal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->unsignedSmallInteger('fiscal_year')->nullable();
            $table->string('version', 30)->nullable();
            $table->string('file_type', 20)->nullable();
            $table->string('file_size', 30)->nullable();
            $table->string('file_path')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->default('bi-file-earmark-text');
            $table->string('color', 30)->default('blue');
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_documents');
        Schema::dropIfExists('portal_events');
        Schema::dropIfExists('news_items');
        Schema::dropIfExists('portal_systems');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
