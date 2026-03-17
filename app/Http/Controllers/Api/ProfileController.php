<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Profile::first();
        return response()->json(['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|string',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'experience_years' => 'nullable|string',
            'projects_count' => 'nullable|string',
            'clients_count' => 'nullable|string',
        ]);

        $profile = Profile::updateOrCreate(
            ['id' => 1], // Assuming ID 1 for the main profile
            $validated
        );

        return response()->json($profile);
    }
}
