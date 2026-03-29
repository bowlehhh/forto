<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Public content no longer uses database tables.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
