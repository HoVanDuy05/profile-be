<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(ContactMessage::latest()->get());
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
