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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('education')->nullable()->change();
            $table->string('experience_years')->nullable()->change();
            $table->string('projects_count')->nullable()->change();
            $table->string('clients_count')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->string('education')->nullable(false)->change();
            $table->string('experience_years')->nullable(false)->change();
            $table->string('projects_count')->nullable(false)->change();
            $table->string('clients_count')->nullable(false)->change();
        });
    }
};
