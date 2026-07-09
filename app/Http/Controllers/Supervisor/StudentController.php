<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = $request->user()->supervisor;

        $students = $supervisor->students()->with(['user', 'internships'])->get();

        return view('supervisor.students.index', compact('students'));
    }

    public function show(Request $request, Student $student)
    {
        $supervisor = $request->user()->supervisor;

        abort_if($student->supervisor_id !== $supervisor->id, 403);

        $student->load('user');
        $internship = $student->internships()->latest('start_date')->first();
        $logs = $internship ? $internship->activityLogs()->latest('log_date')->get() : collect();
        $documents = $internship ? $internship->documents()->latest()->get() : collect();
        $evaluations = $internship ? $internship->evaluations()->with('supervisor.user')->latest('evaluation_date')->get() : collect();

        return view('supervisor.students.show', compact('student', 'internship', 'logs', 'documents', 'evaluations'));
    }
}
