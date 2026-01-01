<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        // dd("test");
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        // dd($request);
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.index');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Access denied']);
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
