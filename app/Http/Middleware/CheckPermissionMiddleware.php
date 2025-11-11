<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('loginForm');
        }

        $routeName = $request->route()?->getName();

        if (! $routeName) {
            return $next($request);
        }

        // if ($user->hasRole('SuperAdmin')) {
        //     return $next($request);
        // }

        if (! $user->can($routeName)) {
            throw UnauthorizedException::forPermissions([$routeName]);
        }

        return $next($request);
    }
}
