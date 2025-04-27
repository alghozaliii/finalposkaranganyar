<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user exists and has the specified role
        if (!$request->user() || $request->user()->role->name !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}