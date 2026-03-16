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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('phone');
            $table->string('location');
            $table->string('education');
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('experience_years');
            $table->string('projects_count');
            $table->string('clients_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
