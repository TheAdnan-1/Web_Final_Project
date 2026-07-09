<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $internship = $this->currentInternship($request);

        $logs = $internship
            ? $internship->activityLogs()->withCount('documents')->with('feedback')->latest('log_date')->paginate(10)
            : collect();

        return view('student.logs.index', compact('internship', 'logs'));
    }

    public function create(Request $request)
    {
        $internship = $this->currentInternship($request);

        if (! $internship) {
            return redirect()->route('student.internship.create')
                ->with('status', 'Please submit your internship information first.');
        }

        return view('student.logs.create', compact('internship'));
    }

    public function store(Request $request)
    {
        $internship = $this->currentInternship($request);

        if (! $internship) {
            abort(403);
        }

        $data = $this->validated($request);
        $data['internship_id'] = $internship->id;

        ActivityLog::create($data);

        return redirect()->route('student.logs.index')->with('status', 'Activity log added.');
    }

    public function edit(Request $request, ActivityLog $log)
    {
        $this->authorizeOwnership($request, $log);

        return view('student.logs.edit', compact('log'));
    }

    public function update(Request $request, ActivityLog $log)
    {
        $this->authorizeOwnership($request, $log);

        $log->update($this->validated($request));

        return redirect()->route('student.logs.index')->with('status', 'Activity log updated.');
    }

    public function show(Request $request, ActivityLog $log)
    {
        $this->authorizeOwnership($request, $log);

        $log->load('feedback.supervisor.user', 'documents');

        return view('student.logs.show', compact('log'));
    }

    public function destroy(Request $request, ActivityLog $log)
    {
        $this->authorizeOwnership($request, $log);

        $log->delete();

        return redirect()->route('student.logs.index')->with('status', 'Activity log removed.');
    }

    private function currentInternship(Request $request)
    {
        return $request->user()->student->internships()->latest('start_date')->first();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'log_date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'hours_spent' => ['required', 'numeric', 'min:0.5', 'max:24'],
        ]);
    }

    private function authorizeOwnership(Request $request, ActivityLog $log): void
    {
        $studentId = $request->user()->student->id ?? null;

        if ($log->internship->student_id !== $studentId) {
            abort(403);
        }
    }
}
