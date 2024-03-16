<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest')->only(['login', 'authenticate']);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required' , 'string'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()) {
                return redirect()->intended('/charts')->with('success');
            } else {
                return redirect()->intended('/zain-report')->with('success');
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
