<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'tags', 
        'demo_link', 'github_link', 'is_featured', 'sort_order'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
    ];
}
