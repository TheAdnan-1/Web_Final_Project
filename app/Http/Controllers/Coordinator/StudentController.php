<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with(['user', 'supervisor.user', 'internships'])
            ->when($request->query('search'), function ($q, $search) {
                $q->where('student_no', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $supervisors = Supervisor::with('user')->get();

        return view('coordinator.students.index', compact('students', 'supervisors'));
    }

    public function create()
    {
        return view('coordinator.students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'min:8'],
            'student_no' => ['required', 'string', 'max:50', 'unique:students,student_no'],
            'department' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'semester' => ['nullable', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_no' => $data['student_no'],
                'department' => $data['department'],
                'program' => $data['program'],
                'semester' => $data['semester'] ?? null,
            ]);
        });

        return redirect()->route('coordinator.students.index')->with('status', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $supervisors = Supervisor::with('user')->get();

        return view('coordinator.students.edit', compact('student', 'supervisors'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($student->user_id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'semester' => ['nullable', 'string', 'max:50'],
            'supervisor_id' => ['nullable', 'exists:supervisors,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $student->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'],
        ]);

        $student->update([
            'department' => $data['department'],
            'program' => $data['program'],
            'semester' => $data['semester'] ?? null,
            'supervisor_id' => $data['supervisor_id'] ?? null,
        ]);

        return redirect()->route('coordinator.students.index')->with('status', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user()->delete();
        $student->delete();

        return back()->with('status', 'Student removed.');
    }
}
