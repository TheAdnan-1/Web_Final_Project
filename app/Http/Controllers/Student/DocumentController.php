<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $internship = $request->user()->student->internships()->latest('start_date')->first();

        $documents = $internship
            ? $internship->documents()->latest()->get()
            : collect();

        return view('student.documents.index', compact('internship', 'documents'));
    }

    public function store(Request $request)
    {
        $internship = $request->user()->student->internships()->latest('start_date')->first();

        if (! $internship) {
            return back()->with('status', 'Please submit your internship information first.');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'activity_log_id' => ['nullable', 'exists:activity_logs,id'],
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'internship_id' => $internship->id,
            'activity_log_id' => $data['activity_log_id'] ?? null,
            'title' => $data['title'],
            'file_path' => $path,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'file_size' => $request->file('file')->getSize(),
        ]);

        return back()->with('status', 'Document uploaded successfully.');
    }

    public function destroy(Request $request, Document $document)
    {
        if ($document->internship->student_id !== $request->user()->student->id) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('status', 'Document deleted.');
    }
}
