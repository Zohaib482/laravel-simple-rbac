<?php

namespace Zohaib482\SimpleRbac\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (! $request->user()?->hasPermissionTo($permissions)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
