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
        Schema::table('projects', function (Blueprint $table) {
            $table->index('title');
            $table->index('created_at');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->index('title');
            $table->index('created_at');
        });

        Schema::table('site_likes', function (Blueprint $table) {
            $table->index('liked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_likes', function (Blueprint $table) {
            $table->dropIndex(['liked_at']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['created_at']);
        });
    }
};
