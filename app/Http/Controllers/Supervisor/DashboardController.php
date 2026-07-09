<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = $request->user()->supervisor;

        $students = $supervisor->students()->with('user', 'internships')->get();
        $studentIds = $students->pluck('id');

        $pendingLogs = ActivityLog::whereHas('internship', fn ($q) => $q->whereIn('student_id', $studentIds))
            ->where('status', 'pending')
            ->with('internship.student.user')
            ->latest('log_date')
            ->take(6)
            ->get();

        $stats = [
            'total_students' => $students->count(),
            'ongoing' => $students->flatMap->internships->where('status', 'ongoing')->count(),
            'completed' => $students->flatMap->internships->where('status', 'completed')->count(),
            'pending_reviews' => ActivityLog::whereHas('internship', fn ($q) => $q->whereIn('student_id', $studentIds))
                ->where('status', 'pending')->count(),
        ];

        return view('supervisor.dashboard', compact('supervisor', 'students', 'pendingLogs', 'stats'));
    }
}
