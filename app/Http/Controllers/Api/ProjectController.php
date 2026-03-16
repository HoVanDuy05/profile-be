<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'tags' => 'nullable|array',
            'demo_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'featured' => 'boolean',
        ]);

        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'image' => 'nullable|string',
            'tags' => 'nullable|array',
            'demo_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'featured' => 'boolean',
        ]);

        $project->update($validated);
        return response()->json($project);
    }

    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
