<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequireRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware([\App\Http\Middleware\RequireRole::class . ':admin'])
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $roleName = null;
        if (! empty($user->role_id)) {
            $roleName = DB::table('roles')->where('id', $user->role_id)->value('name');
        }
        $current = strtolower($roleName ?? ($user->position ?? ''));

        if (strtolower($role) !== $current) {
            // If user arrived here by typing another role's URL, go back to previous page
            $previous = url()->previous();
            $currentUrl = url()->full();
            if ($previous && $previous !== $currentUrl) {
                return redirect()->to($previous)->with('error', 'Unauthorized access.');
            }
            // Fallback to dashboard if we can't determine a previous page
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
