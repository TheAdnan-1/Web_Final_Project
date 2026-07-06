<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
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
        if (! $this->verifyRecaptcha($request)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Captcha verification failed. Please try again.',
            ])->onlyInput('email');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (Auth::user()->status === 'inactive') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact the coordinator.',
            ]);
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
