<?php

namespace Zohaib482\SimpleRbac\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()?->hasAnyRole($roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
