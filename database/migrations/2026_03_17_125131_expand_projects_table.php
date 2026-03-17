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
            $table->longText('content')->nullable()->after('description');
            $table->string('source_code_zip')->nullable()->after('github_link');
            $table->json('folder_structure')->nullable()->after('source_code_zip');
            $table->string('live_link')->nullable()->after('demo_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['content', 'source_code_zip', 'folder_structure', 'live_link']);
        });
    }
};
