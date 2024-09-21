<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch stats for the dashboard overview
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_topics' => Topic::count(),
            'total_lessons' => Lesson::count(),

        ];

        $featured = Course::where('is_featured', true)->get();


        // Render the admin dashboard with stats
        return Inertia::render('Admin/Index', [
            'stats' => $stats,
            'courses' => $featured
        ]);
    }


    public function users()
    {
        // Fetch all users and send to the Inertia view
        $users = User::all();
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }
}
