<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;

class CVController extends Controller
{
    public function index()
    {
        return response()->json([
            'profile' => Profile::first(),
            'skills' => Skill::all()->groupBy('category'),
            'projects' => Project::all(),
            'experiences' => Experience::all()->groupBy('type'),
            'debug' => [
                'user_found' => \App\Models\User::where('email', 'vanduyho717@gmail.com')->exists(),
                'user_count' => \App\Models\User::count(),
                'db_name' => config('database.connections.mysql.database'),
                'db_host' => config('database.connections.mysql.host'),
                'db_user' => config('database.connections.mysql.username'),
            ]
        ]);
    }
}
