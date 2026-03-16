<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $profile = Profile::firstOrFail();
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'title' => 'string|max:255',
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
 
        $profile->update($validated);
 
        return response()->json($profile);
    }
}
