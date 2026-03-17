<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'description', 'content', 'image', 'tags', 
        'demo_link', 'github_link', 'live_link', 'source_code_zip', 
        'folder_structure', 'is_featured', 'sort_order'
    ];

    protected $casts = [
        'tags' => 'array',
        'folder_structure' => 'array',
        'is_featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($project) {
            if (empty($project->slug) || $project->isDirty('title')) {
                $project->slug = static::generateUniqueSlug($project->title);
            }
        });
    }

    private static function generateUniqueSlug($title)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function customFields()
    {
        return $this->morphMany(CustomField::class, 'model', 'model_type', 'model_id');
    }
}
