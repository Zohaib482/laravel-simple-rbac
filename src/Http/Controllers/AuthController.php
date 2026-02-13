<?php

namespace Zohaib482\SimpleRbac\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    // Show login form
    public function loginForm()
    {
        return view('simplerbac::auth.login');
    }

    // Handle login
    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    // Show register form
    public function registerForm()
    {
        return view('simplerbac::auth.register');
    }

    // Handle registration
    public function registerSubmit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(config('simplerbac.default_role', 'user'));

        // login new user
        Auth::login($user);

        // ✅ SEND VERIFICATION EMAIL
        $user->sendEmailVerificationNotification();

        return redirect('/email/verify');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
