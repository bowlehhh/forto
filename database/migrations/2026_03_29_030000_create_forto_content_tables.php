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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 120);
            $table->string('category', 80);
            $table->text('summary');
            $table->json('stack');
            $table->string('status', 40);
            $table->string('github_url')->nullable();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 120);
            $table->json('items');
            $table->timestamps();
        });

        Schema::create('site_likes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 40)->unique();
            $table->timestamp('liked_at');
            $table->timestamps();
        });

        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('token', 120)->unique();
            $table->string('name', 40);
            $table->timestamp('first_visited_at');
            $table->timestamp('last_visited_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
        Schema::dropIfExists('site_likes');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('projects');
    }
};
