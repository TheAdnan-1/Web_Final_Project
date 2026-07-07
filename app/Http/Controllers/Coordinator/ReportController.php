<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $departmentBreakdown = Student::select('department', DB::raw('count(*) as total_students'))
            ->groupBy('department')
            ->orderBy('department')
            ->get()
            ->map(function ($row) {
                $row->ongoing = Internship::whereHas('student', fn ($s) => $s->where('department', $row->department))
                    ->where('status', 'ongoing')->count();
                $row->completed = Internship::whereHas('student', fn ($s) => $s->where('department', $row->department))
                    ->where('status', 'completed')->count();
                $row->avg_rating = round((float) Evaluation::whereHas('internship.student', fn ($s) => $s->where('department', $row->department))
                    ->avg('overall_rating'), 2);

                return $row;
            });

        $topPerformers = Evaluation::with('internship.student.user')
            ->orderByDesc('overall_rating')
            ->take(5)
            ->get();

        return view('coordinator.reports.index', compact('departmentBreakdown', 'topPerformers'));
    }
}
