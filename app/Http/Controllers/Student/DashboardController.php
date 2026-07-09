<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student()->with('supervisor.user')->firstOrFail();
        $internship = $student->internships()->latest('start_date')->first();

        $recentLogs = collect();
        $recentFeedback = collect();

        if ($internship) {
            $recentLogs = $internship->activityLogs()->latest('log_date')->take(5)->get();
            $recentFeedback = \App\Models\Feedback::whereHas('activityLog', function ($q) use ($internship) {
                $q->where('internship_id', $internship->id);
            })->with(['activityLog', 'supervisor.user'])->latest()->take(3)->get();
        }

        return view('student.dashboard', compact('student', 'internship', 'recentLogs', 'recentFeedback'));
    }
}
