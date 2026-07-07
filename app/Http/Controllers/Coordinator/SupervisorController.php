<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        $supervisors = Supervisor::with(['user', 'students'])
            ->when($request->query('search'), function ($q, $search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('coordinator.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        return view('coordinator.supervisors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'min:8'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'supervisor',
            ]);

            Supervisor::create([
                'user_id' => $user->id,
                'designation' => $data['designation'],
                'department' => $data['department'],
                'company_name' => $data['company_name'] ?? null,
            ]);
        });

        return redirect()->route('coordinator.supervisors.index')->with('status', 'Supervisor added successfully.');
    }

    public function edit(Supervisor $supervisor)
    {
        $supervisor->load('user');

        return view('coordinator.supervisors.edit', compact('supervisor'));
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($supervisor->user_id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $supervisor->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'],
        ]);

        $supervisor->update([
            'designation' => $data['designation'],
            'department' => $data['department'],
            'company_name' => $data['company_name'] ?? null,
        ]);

        return redirect()->route('coordinator.supervisors.index')->with('status', 'Supervisor updated successfully.');
    }

    public function destroy(Supervisor $supervisor)
    {
        $supervisor->user()->delete();
        $supervisor->delete();

        return back()->with('status', 'Supervisor removed.');
    }
}
