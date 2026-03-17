<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
 
class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        Log::info('Media list fetched', ['count' => $media->count()]);
        return response()->json($media);
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB max
        ]);
 
        $file = $request->file('file');
        
        try {
            // Priority: Cloudinary
            Log::info('Attempting Cloudinary upload', ['file' => $file->getClientOriginalName()]);
            $uploadResult = Cloudinary::upload($file->getRealPath());
            $url = $uploadResult->getSecurePath();
            $publicId = $uploadResult->getPublicId();
            $filename = $file->getClientOriginalName();
            Log::info('Cloudinary upload success', ['url' => $url, 'public_id' => $publicId]);
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed, falling back to local', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            // Fallback: Local Storage
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $url = '/storage/' . $path; // Store relative path for consistency with ProfileManager
            $publicId = null;
        }
 
        $media = Media::create([
            'filename' => $filename,
            'url' => $url,
            'public_id' => $publicId,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        Log::info('File uploaded', [
            'id' => $media->id,
            'url' => $media->url,
            'driver' => $publicId ? 'Cloudinary' : 'Local'
        ]);

        return response()->json($media, 201);
    }
 
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        
        // Remove from Cloudinary if applicable
        if ($media->public_id) {
            try {
                Cloudinary::destroy($media->public_id);
            } catch (\Exception $e) {
                // Ignore errors on deletion failure for cloud
            }
        }
 
        // Remove from storage if local
        if (str_contains($media->url, '/storage/')) {
            $path = str_replace('/storage/', 'public/', $media->url);
            Storage::delete($path);
        }
 
        $media->delete();
        return response()->json(null, 204);
    }
}
