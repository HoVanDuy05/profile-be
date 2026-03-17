<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::withCount('customFields')->latest('sort_order')->get());
    }

    public function show($id)
    {
        $query = Project::with('customFields');
        
        if (is_numeric($id)) {
            $project = $query->findOrFail($id);
        } else {
            $project = $query->where('slug', $id)->firstOrFail();
        }
        
        return response()->json($project);
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Project Store Request Starting...', $request->all());

        try {
            // Explicitly parse JSON fields from multipart/form-data
            $jsonFields = ['tags', 'folder_structure', 'custom_fields'];
            foreach ($jsonFields as $field) {
                if (is_string($request->input($field))) {
                    $decoded = json_decode($request->input($field), true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $request->merge([$field => $decoded]);
                    }
                }
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'image' => 'nullable|string',
                'tags' => 'nullable|array',
                'demo_link' => 'nullable|url',
                'github_link' => 'nullable|url',
                'live_link' => 'nullable|url',
                'is_featured' => 'boolean',
                'sort_order' => 'integer',
                'folder_structure' => 'nullable|array',
                'custom_fields' => 'nullable|array',
                'source_code_file' => 'nullable|file|mimes:zip|max:51200',
            ]);

            \Illuminate\Support\Facades\DB::beginTransaction();

            if ($request->hasFile('source_code_file')) {
                $path = $request->file('source_code_file')->store('projects/zips', 'public');
                $validated['source_code_zip'] = '/storage/' . $path;
            }

            $project = Project::create(\Illuminate\Support\Arr::except($validated, ['custom_fields', 'source_code_file']));

            if (!empty($validated['custom_fields'])) {
                foreach ($validated['custom_fields'] as $field) {
                    if (empty($field['name']))
                        continue; // Skip empty fields

                    if (isset($field['options']) && is_string($field['options']))
                        $field['options'] = json_decode($field['options'], true);
                    if (isset($field['validation_rules']) && is_string($field['validation_rules']))
                        $field['validation_rules'] = json_decode($field['validation_rules'], true);

                    $project->customFields()->create($field);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            \Illuminate\Support\Facades\Log::info('Project Created Successfully ID: ' . $project->id);

            return response()->json($project->load('customFields'), 201);
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Project Creation Failed: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            return response()->json(['message' => 'Failed to create project', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Explicitly parse JSON fields from multipart/form-data
        $tags = $request->input('tags');
        if (is_string($tags)) {
            $decoded = json_decode($tags, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['tags' => $decoded]);
            }
        }

        $folder = $request->input('folder_structure');
        if (is_string($folder)) {
            $decoded = json_decode($folder, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['folder_structure' => $decoded]);
            }
        }

        $fields = $request->input('custom_fields');
        if (is_string($fields)) {
            $decoded = json_decode($fields, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['custom_fields' => $decoded]);
            }
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'string',
            'content' => 'nullable|string',
            'image' => 'nullable|string',
            'tags' => 'nullable|array',
            'demo_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'live_link' => 'nullable|url',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'folder_structure' => 'nullable|array',
            'custom_fields' => 'nullable|array',
            'source_code_file' => 'nullable|file|mimes:zip|max:51200',
        ]);

        if ($request->hasFile('source_code_file')) {
            $path = $request->file('source_code_file')->store('projects/zips', 'public');
            $validated['source_code_zip'] = '/storage/' . $path;
        }

        $project->update(\Illuminate\Support\Arr::except($validated, ['custom_fields', 'source_code_file']));

        if (isset($validated['custom_fields'])) {
            $project->customFields()->delete();
            foreach ($validated['custom_fields'] as $field) {
                // Ensure field is an array (might be string from FormData if not handled at store)
                if (is_string($field))
                    $field = json_decode($field, true);

                if (isset($field['options']) && is_string($field['options'])) {
                    $field['options'] = json_decode($field['options'], true);
                }
                if (isset($field['validation_rules']) && is_string($field['validation_rules'])) {
                    $field['validation_rules'] = json_decode($field['validation_rules'], true);
                }

                $project->customFields()->create($field);
            }
        }

        return response()->json($project->load('customFields'));
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->customFields()->delete();
        $project->delete();
        return response()->json(null, 204);
    }
}
