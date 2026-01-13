<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Sprawdzenie, czy użytkownik ma przypisaną rolę
        if (!$user->role) {
            abort(403, 'Brak przypisanej roli dla użytkownika.');
        }

        $allowedRoles = explode('|', $roles);

        if (!in_array($user->role->name, $allowedRoles)) {
            abort(403, 'Brak dostępu: nie masz odpowiedniej roli.');
        }

        return $next($request);
    }
}
