<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Project');
            $table->text('summary')->nullable();
            $table->text('stack')->nullable();
            $table->string('status')->default('Ready');
            $table->string('github_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['sort_order', 'id']);
        });

        Schema::create('skills', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('items')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['sort_order', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('projects');
    }
};
