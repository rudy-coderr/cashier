<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        if (strtolower($role) !== $user->roleName()) {
            $previous = url()->previous();
            $currentUrl = url()->full();
            $home = url('/');
            if ($previous && $previous !== $currentUrl && $previous !== $home) {
                return redirect()->to($previous)->with('error', 'Unauthorized access.');
            }
            return redirect()->route($user->dashboardRoute())->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
