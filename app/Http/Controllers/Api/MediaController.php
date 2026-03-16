<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
 
class MediaController extends Controller
{
    public function index()
    {
        return response()->json(Media::latest()->get());
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB max
        ]);
 
        $file = $request->file('file');
        
        try {
            // Priority: Cloudinary
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath())->getSecurePath();
            $publicId = Cloudinary::getPublicId();
            $url = $uploadedFileUrl;
            $filename = $file->getClientOriginalName();
        } catch (\Exception $e) {
            // Fallback: Local Storage
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $url = Storage::url($path);
            $publicId = null;
        }
 
        $media = Media::create([
            'filename' => $filename,
            'url' => $url,
            'public_id' => $publicId,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
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
