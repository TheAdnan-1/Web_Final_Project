<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $internships = Internship::with('student.user', 'student.supervisor.user')
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->query('department'), function ($q, $dept) {
                $q->whereHas('student', fn ($s) => $s->where('department', $dept));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $departments = \App\Models\Student::select('department')->distinct()->pluck('department');

        return view('coordinator.internships.index', compact('internships', 'departments'));
    }

    public function show(Internship $internship)
    {
        $internship->load('student.user', 'student.supervisor.user', 'activityLogs', 'evaluations.supervisor.user', 'documents');

        return view('coordinator.internships.show', compact('internship'));
    }

    public function update(Request $request, Internship $internship)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'ongoing', 'completed', 'terminated'])],
        ]);

        $internship->update($data);

        return back()->with('status', 'Internship status updated.');
    }
}
