<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'students' => Student::count(),
            'supervisors' => Supervisor::count(),
            'ongoing' => Internship::where('status', 'ongoing')->count(),
            'completed' => Internship::where('status', 'completed')->count(),
            'pending' => Internship::where('status', 'pending')->count(),
        ];

        $departmentStats = Student::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        $statusStats = Internship::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $recentInternships = Internship::with('student.user')->latest()->take(6)->get();
        $unassignedStudents = Student::whereNull('supervisor_id')->with('user')->take(5)->get();

        return view('coordinator.dashboard', compact(
            'stats', 'departmentStats', 'statusStats', 'recentInternships', 'unassignedStudents'
        ));
    }
}
