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
            $table->string('title')->nullable()->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('category')->nullable()->change();
            $table->integer('level')->nullable()->change();
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('company')->nullable()->change();
            $table->string('period')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not implementing detailed down here as we're going towards total flexibility
    }
};
