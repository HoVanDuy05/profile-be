<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\ContactMessage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStats()
    {
        return response()->json([
            'stats' => [
                [
                    'title' => 'Total Skills',
                    'value' => (string) Skill::count(),
                    'icon' => 'IconCode',
                    'color' => 'blue',
                    'trend' => Skill::where('created_at', '>=', now()->subMonth())->count() . ' new this month'
                ],
                [
                    'title' => 'Active Projects',
                    'value' => (string) Project::count(),
                    'icon' => 'IconFolder',
                    'color' => 'violet',
                    'trend' => Project::where('is_featured', true)->count() . ' featured'
                ],
                [
                    'title' => 'Experience',
                    'value' => Experience::where('type', 'work')->count() . ' roles',
                    'icon' => 'IconBriefcase',
                    'color' => 'teal',
                    'trend' => Experience::where('is_current', true)->count() . ' current'
                ],
                [
                    'title' => 'Unread Messages',
                    'value' => (string) ContactMessage::where('is_read', false)->count(),
                    'icon' => 'IconMessages',
                    'color' => 'pink',
                    'trend' => 'Requires attention'
                ],
            ],
            'recent_activities' => ActivityLog::with('user')->latest()->take(5)->get(),
            'completion' => [
                ['label' => 'Profile Information', 'value' => 100],
                ['label' => 'Project Documentation', 'value' => Project::whereNotNull('content')->count() > 0 ? 80 : 30],
                ['label' => 'Skills Inventory', 'value' => Skill::count() > 10 ? 100 : 50],
            ]
        ]);
    }
}
