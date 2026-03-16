<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getLoginHistory(Request $request)
    {
        $history = LoginHistory::where('user_id', $request->user()->id)
            ->latest()
            ->limit(50)
            ->get();
            
        return response()->json($history);
    }

    public function getActivityLogs(Request $request)
    {
        $logs = ActivityLog::where('user_id', $request->user()->id)
            ->latest()
            ->limit(100)
            ->get();
            
        return response()->json($logs);
    }

    public function getActiveSessions(Request $request)
    {
        // For Sanctum, we can list tokens
        $tokens = $request->user()->tokens()->latest()->get();
        
        return response()->json($tokens);
    }
}
