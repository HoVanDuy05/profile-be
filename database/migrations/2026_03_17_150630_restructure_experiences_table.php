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
        Schema::table('experiences', function (Blueprint $table) {
            // Drop old columns that are no longer needed or will be replaced
            $table->dropColumn(['title', 'period']);
            
            // Add new columns matching ExperienceManager.tsx
            $table->string('position')->nullable()->after('company');
            $table->string('start_date')->nullable()->after('position');
            $table->string('end_date')->nullable()->after('start_date');
            $table->boolean('is_current')->default(false)->after('end_date');
            
            // Modify existing columns
            $table->string('company')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('type')->nullable()->change(); // Changed from enum to string for more flexibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('period')->after('company');
            $table->dropColumn(['position', 'start_date', 'end_date', 'is_current']);
        });
    }
};
