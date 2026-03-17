<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CustomField extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'name',
        'value',
        'type',
        'sort_order',
        'is_active',
        'options',
        'group',
        'validation_rules',
        'display_as',
        'placeholder',
        'help_text',
        'icon',
        'class',
        'width',
        'height',
        'max_length',
        'min_length',
        'max_value',
        'min_value',
        'step',
        'rows',
        'cols',
        'pattern',
        'required',
        'readonly',
        'disabled',
        'hidden',
    ];
    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'required' => 'boolean',
        'readonly' => 'boolean',
        'disabled' => 'boolean',
        'hidden' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
    ];

    /**
     * Get the parent model (Project, etc.)
     */
    public function fieldable(): MorphTo
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }
}
