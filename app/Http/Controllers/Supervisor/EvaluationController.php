<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Internship;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = $request->user()->supervisor;

        $evaluations = $supervisor->evaluations()->with('internship.student.user')->latest('evaluation_date')->paginate(10);

        return view('supervisor.evaluations.index', compact('evaluations'));
    }

    public function create(Request $request, Internship $internship)
    {
        $this->authorizeAccess($request, $internship);

        return view('supervisor.evaluations.create', compact('internship'));
    }

    public function store(Request $request, Internship $internship)
    {
        $this->authorizeAccess($request, $internship);

        $data = $request->validate([
            'technical_skills' => ['required', 'integer', 'min:1', 'max:5'],
            'communication' => ['required', 'integer', 'min:1', 'max:5'],
            'teamwork' => ['required', 'integer', 'min:1', 'max:5'],
            'punctuality' => ['required', 'integer', 'min:1', 'max:5'],
            'initiative' => ['required', 'integer', 'min:1', 'max:5'],
            'comments' => ['nullable', 'string', 'max:2000'],
            'evaluation_date' => ['required', 'date'],
        ]);

        $overall = round((
            $data['technical_skills'] + $data['communication'] + $data['teamwork'] +
            $data['punctuality'] + $data['initiative']
        ) / 5, 2);

        Evaluation::create([
            ...$data,
            'internship_id' => $internship->id,
            'supervisor_id' => $request->user()->supervisor->id,
            'overall_rating' => $overall,
        ]);

        return redirect()->route('supervisor.students.show', $internship->student_id)
            ->with('status', 'Evaluation submitted successfully.');
    }

    private function authorizeAccess(Request $request, Internship $internship): void
    {
        $supervisorId = $request->user()->supervisor->id ?? null;

        if ($internship->student->supervisor_id !== $supervisorId) {
            abort(403);
        }
    }
}
