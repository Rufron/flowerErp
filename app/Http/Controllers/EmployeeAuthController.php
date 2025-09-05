<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthController extends Controller
{
    public function showLogin()
    {
        return view('employees.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login on the "employee" guard
        if (Auth::guard('employee')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('employees.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employees.login');
    }
}
