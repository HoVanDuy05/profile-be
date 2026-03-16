<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
 
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        $user = User::where('email', $request->email)->first();
 
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
 
        // Record Login History
        $userAgent = $request->header('User-Agent');
        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'device_type' => $this->getDeviceType($userAgent),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'login_at' => now(),
        ]);
 
        // Log Activity
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in to admin panel',
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
        ]);
 
        $token = $user->createToken('admin-token')->plainTextToken;
 
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
 
    private function getDeviceType($ua)
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) return 'Tablet';
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $ua)) return 'Mobile';
        return 'Desktop';
    }
 
    private function getOS($ua)
    {
        if (preg_match('/windows/i', $ua)) return 'Windows';
        if (preg_match('/macintosh|mac os x/i', $ua)) return 'macOS';
        if (preg_match('/android/i', $ua)) return 'Android';
        if (preg_match('/iphone|ipad|ipod/i', $ua)) return 'iOS';
        if (preg_match('/linux/i', $ua)) return 'Linux';
        return 'Unknown';
    }
 
    private function getBrowser($ua)
    {
        if (preg_match('/chrome/i', $ua)) return 'Chrome';
        if (preg_match('/safari/i', $ua)) return 'Safari';
        if (preg_match('/firefox/i', $ua)) return 'Firefox';
        if (preg_match('/edge/i', $ua)) return 'Edge';
        if (preg_match('/opera/i', $ua)) return 'Opera';
        return 'Unknown';
    }
 
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
 
        return response()->json(['message' => 'Logged out successfully']);
    }
}
