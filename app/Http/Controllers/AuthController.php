<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('home');
            }

        }

        return back()->withErrors([
            'email' => 'Email atau password yang anda masukkan salah.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('app.view.login');
    }

    public function profile()
    {
        return view('app.auth.profile');
    }
}
