<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // formularz logowania
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // logowanie
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role->name === 'Administrator') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role->name === 'Pracownik') {
                return redirect()->route('orders.manage');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Niepoprawne dane logowania.',
        ]);
    }

    // wylogowanie
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
