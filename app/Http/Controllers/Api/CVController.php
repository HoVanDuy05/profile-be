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
        ]);
    }
}
