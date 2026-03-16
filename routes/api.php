<?php

use App\Http\Controllers\Api\CVController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;
 
// Public routes
Route::get('/cv-data', [CVController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/debug-auth', function() {
    $user = \App\Models\User::where('email', 'vanduyho717@gmail.com')->first();
    return [
        'user_found' => (bool)$user,
        'pass_verify' => $user ? \Illuminate\Support\Facades\Hash::check('12345678', $user->password) : false,
        'app_env' => config('app.env'),
        'db_name' => config('database.connections.mysql.database'),
    ];
});
 
// Protected Admin CRUD routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('experience', ExperienceController::class);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::get('/messages', [MessageController::class, 'index']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
    Route::apiResource('media', MediaController::class);
    
    // Settings & Security
    Route::get('/settings/login-history', [\App\Http\Controllers\Api\SettingsController::class, 'getLoginHistory']);
    Route::get('/settings/activity-logs', [\App\Http\Controllers\Api\SettingsController::class, 'getActivityLogs']);
    Route::get('/settings/active-sessions', [\App\Http\Controllers\Api\SettingsController::class, 'getActiveSessions']);
});
