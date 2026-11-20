<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ---------- Register ----------
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:user,admin',
        ]);

        User::create([
    'full_name' => $data['name'],
    'email'     => $data['email'],
    'password'  => Hash::make($data['password']),
    'role'      => $data['role'],
]);

        return redirect('/login')->with('success', 'Account created. Please log in.');
    }

    // ---------- Login pages ----------
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showUserLogin()
    {
        return view('auth.user-login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    // ---------- Login logic ----------
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $expectedRole = $request->input('role'); // 'user' or 'admin'

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // role eka waradi nam block karanna
            if ($expectedRole && $user->role !== $expectedRole) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'This account is not a ' . $expectedRole . ' account.'])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            return $user->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email or password is incorrect.'])
            ->withInput($request->only('email'));
    }

    // ---------- Logout ----------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


    // ---------- Forgot password ----------
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.exists' => 'No account found with that email.',
        ]);

        User::where('email', $data['email'])
            ->update(['password' => Hash::make($data['password'])]);

        return redirect('/login')->with('success', 'Password updated. Please log in.');
    }
}