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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('name');
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, longtext, number, date, toggle
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('options')->nullable(); // For select, radio, checkbox
            $table->string('group')->nullable(); // For grouping fields
            $table->string('validation_rules')->nullable(); // For validation rules
            $table->string('display_as')->nullable(); // For display format
            $table->string('placeholder')->nullable(); // For placeholder text
            $table->string('help_text')->nullable(); // For help text
            $table->string('icon')->nullable(); // For icon
            $table->string('class')->nullable(); // For CSS class
            $table->string('width')->default('100%'); // For width
            $table->string('height')->default('auto'); // For height
            $table->string('max_length')->nullable(); // For max length
            $table->string('min_length')->nullable(); // For min length
            $table->string('max_value')->nullable(); // For max value
            $table->string('min_value')->nullable(); // For min value
            $table->string('step')->nullable(); // For step
            $table->string('rows')->default(3); // For rows
            $table->string('cols')->default(50); // For cols
            $table->string('pattern')->nullable(); // For pattern
            $table->string('required')->default(false); // For required
            $table->string('readonly')->default(false); // For readonly
            $table->string('disabled')->default(false); // For disabled
            $table->string('hidden')->default(false); // For hidden


            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
