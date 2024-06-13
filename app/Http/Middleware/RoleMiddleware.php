<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if ($user && $user->role === $role) {
            return $next($request);
        }

        return redirect()->route('no-access');
    }
}
