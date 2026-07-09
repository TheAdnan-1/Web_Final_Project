<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student()->with('supervisor.user')->firstOrFail();
        $internship = $student->internships()->latest('start_date')->first();

        abort_if(! $internship, 404, 'No internship record found yet.');

        $internship->load(['activityLogs' => fn ($q) => $q->orderBy('log_date'), 'evaluations.supervisor.user']);
        $logs = $internship->activityLogs;
        $evaluation = $internship->evaluations()->latest('evaluation_date')->first();

        return view('student.report.index', compact('student', 'internship', 'logs', 'evaluation'));
    }
}
