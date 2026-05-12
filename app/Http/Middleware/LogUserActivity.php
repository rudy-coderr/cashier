<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            $user = Auth::user();
            // only log for authenticated users and state-changing requests
            if ($user && in_array($request->method(), ['POST','PUT','PATCH','DELETE'])) {
                $action = $request->method() . ' ' . $request->path();
                $desc = '';
                // build brief description from route name or input (excluding common sensitive fields)
                $routeName = optional($request->route())->getName();
                if ($routeName) {
                    $desc = 'Route: ' . $routeName;
                } else {
                    $input = $request->except(['password','password_confirmation','_token']);
                    $desc = 'Payload: ' . json_encode(array_slice($input, 0, 5));
                }

                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => $action,
                    'description' => $desc,
                    'ip_address' => $request->ip(),
                ]);
            }
        } catch (\Throwable $e) {
            // fail silently — do not block the request
        }

        return $response;
    }
}
