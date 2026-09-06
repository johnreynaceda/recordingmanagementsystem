<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Restrict the request to users with one of the allowed roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        abort_unless(
            $request->user() && in_array($request->user()->user_type, $roles, true),
            403,
            'You are not authorized to access this area.'
        );

        return $next($request);
    }
}
