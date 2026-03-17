<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return response()->json(Experience::all());
    }

    public function show($id)
    {
        return response()->json(Experience::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'nullable|string',
            'is_current' => 'boolean',
            'type' => 'required|in:work,education',
        ]);

        $experience = Experience::create($validated);
        return response()->json($experience, 201);
    }

    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);
        $validated = $request->validate([
            'company' => 'string|max:255',
            'position' => 'string|max:255',
            'description' => 'string',
            'start_date' => 'string',
            'end_date' => 'nullable|string',
            'is_current' => 'boolean',
            'type' => 'in:work,education',
        ]);

        $experience->update($validated);
        return response()->json($experience);
    }

    public function destroy($id)
    {
        Experience::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
