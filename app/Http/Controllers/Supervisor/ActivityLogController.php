<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Feedback;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = $request->user()->supervisor;
        $studentIds = $supervisor->students()->pluck('id');

        $status = $request->query('status', 'pending');

        $logs = ActivityLog::whereHas('internship', fn ($q) => $q->whereIn('student_id', $studentIds))
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->with('internship.student.user', 'feedback')
            ->latest('log_date')
            ->paginate(10)
            ->withQueryString();

        return view('supervisor.logs.index', compact('logs', 'status'));
    }

    public function show(Request $request, ActivityLog $log)
    {
        $this->authorizeAccess($request, $log);

        $log->load('internship.student.user', 'feedback.supervisor.user', 'documents');

        return view('supervisor.logs.show', compact('log'));
    }

    public function storeFeedback(Request $request, ActivityLog $log)
    {
        $this->authorizeAccess($request, $log);

        $data = $request->validate([
            'comment' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Feedback::updateOrCreate(
            ['activity_log_id' => $log->id],
            [
                'supervisor_id' => $request->user()->supervisor->id,
                'comment' => $data['comment'],
                'rating' => $data['rating'],
            ]
        );

        $log->update(['status' => 'reviewed']);

        return back()->with('status', 'Feedback submitted and log marked reviewed.');
    }

    private function authorizeAccess(Request $request, ActivityLog $log): void
    {
        $supervisorId = $request->user()->supervisor->id ?? null;

        if ($log->internship->student->supervisor_id !== $supervisorId) {
            abort(403);
        }
    }
}
