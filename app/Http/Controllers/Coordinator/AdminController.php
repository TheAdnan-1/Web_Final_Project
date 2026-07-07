<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::where('role', 'coordinator')
            ->when($request->query('search'), fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('coordinator.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('coordinator.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'coordinator',
        ]);

        return redirect()->route('coordinator.admins.index')->with('status', 'Admin account created successfully.');
    }

    public function edit(User $admin)
    {
        abort_unless($admin->role === 'coordinator', 404);

        return view('coordinator.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        abort_unless($admin->role === 'coordinator', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($admin->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => ['nullable', 'min:8'],
        ]);

        if ($admin->id === $request->user()->id && $data['status'] === 'inactive') {
            return back()->withErrors(['status' => 'You cannot deactivate your own account.'])->withInput();
        }

        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'],
        ]);

        if (! empty($data['password'])) {
            $admin->update(['password' => Hash::make($data['password'])]);
        }

        return redirect()->route('coordinator.admins.index')->with('status', 'Admin account updated.');
    }

    public function destroy(Request $request, User $admin)
    {
        abort_unless($admin->role === 'coordinator', 404);

        if ($admin->id === $request->user()->id) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        if (User::where('role', 'coordinator')->count() <= 1) {
            return back()->withErrors(['error' => 'At least one admin account must remain.']);
        }

        $admin->delete();

        return back()->with('status', 'Admin account removed.');
    }
}
