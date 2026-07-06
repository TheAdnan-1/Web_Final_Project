<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /**
     * Public self-registration is for students only. Supervisor and admin
     * accounts carry real authority (evaluating students, managing records),
     * so they are created and vetted by a coordinator instead — see
     * Coordinator\SupervisorController and Coordinator\AdminController.
     */
    public function create()
    {
        return view('auth.register');
    }

    private function verifyRecaptcha(Request $request): bool
    {
        if (app()->environment('local') && in_array($request->getHost(), ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }

        $token = $request->input('g-recaptcha-response');

        if (blank($token)) {
            return false;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
        ]);

        $data = $response->json();

        return ! empty($data['success']) && (($data['score'] ?? 0) >= 0.5);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', 'min:8'],
            'student_no' => ['required', 'string', 'max:50', 'unique:students,student_no'],
            'department' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'semester' => ['nullable', 'string', 'max:50'],
        ]);

        if (! $this->verifyRecaptcha($request)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Captcha verification failed. Please try again.',
            ])->onlyInput(['name', 'email', 'phone', 'student_no', 'department', 'program', 'semester']);
        }

        $user = DB::transaction(function () use ($data) {
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

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
