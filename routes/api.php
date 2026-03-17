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
Route::get('/cv-data', [CVController::class , 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public GET routes for resources
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/skills/{id}', [SkillController::class, 'show']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::get('/experience', [ExperienceController::class, 'index']);
Route::get('/experience/{id}', [ExperienceController::class, 'show']);
Route::get('/profile', [ProfileController::class, 'show']);

// Protected Admin CRUD routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/stats', [\App\Http\Controllers\Api\DashboardController::class, 'getStats']);
    Route::post('/logout', [AuthController::class , 'logout']);
    
    // Modification routes only
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{id}', [SkillController::class, 'update']);
    Route::delete('/skills/{id}', [SkillController::class, 'destroy']);
    
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    
    Route::post('/experience', [ExperienceController::class, 'store']);
    Route::put('/experience/{id}', [ExperienceController::class, 'update']);
    Route::delete('/experience/{id}', [ExperienceController::class, 'destroy']);

    Route::put('/profile', [ProfileController::class , 'update']);
    
    Route::get('/messages', [MessageController::class , 'index']);
    Route::delete('/messages/{id}', [MessageController::class , 'destroy']);
    
    Route::apiResource('media', MediaController::class);

    // Settings & Security
    Route::get('/settings/login-history', [\App\Http\Controllers\Api\SettingsController::class , 'getLoginHistory']);
    Route::get('/settings/activity-logs', [\App\Http\Controllers\Api\SettingsController::class , 'getActivityLogs']);
    Route::get('/settings/active-sessions', [\App\Http\Controllers\Api\SettingsController::class , 'getActiveSessions']);
});
