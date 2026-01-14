<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    // formularz rejestracji
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // rejestracja użytkownika
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $clientRole = Role::firstOrCreate(['name' => 'Klient']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $clientRole->id,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
