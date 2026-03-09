<?php

namespace App\Http\Middleware;

use App\Support\Auth\RoleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (! RoleHelper::userHasAnyRole($request->user()->loadMissing('roles'), $roles)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
