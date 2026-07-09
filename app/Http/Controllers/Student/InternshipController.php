<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function create(Request $request)
    {
        $student = $request->user()->student;
        $internship = $student->internships()->latest('start_date')->first();

        return view('student.internship.create', compact('internship'));
    }

    public function store(Request $request)
    {
        $student = $request->user()->student;

        $data = $this->validated($request);
        $data['student_id'] = $student->id;

        Internship::create($data);

        return redirect()->route('dashboard')->with('status', 'Internship information submitted successfully.');
    }

    public function update(Request $request, Internship $internship)
    {
        $this->authorizeOwnership($request, $internship);

        $internship->update($this->validated($request));

        return redirect()->route('dashboard')->with('status', 'Internship information updated successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'total_hours_required' => ['required', 'integer', 'min:1', 'max:5000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function authorizeOwnership(Request $request, Internship $internship): void
    {
        if ($internship->student_id !== $request->user()->student->id) {
            abort(403);
        }
    }
}
