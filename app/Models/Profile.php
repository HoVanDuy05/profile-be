<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'title', 'email', 'phone', 'location', 'education', 
        'bio', 'avatar', 'linkedin', 'github', 
        'experience_years', 'projects_count', 'clients_count'
    ];
}
