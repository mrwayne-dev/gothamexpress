<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect($this->defaultFor(Auth::user()->role));
        }
        return $next($request);
    }

    public static function defaultFor(UserRole|string|null $role): string
    {
        $value = $role instanceof UserRole ? $role : UserRole::tryFrom((string) $role);
        return $value && $value->isAdmin() ? '/admin/dashboard' : '/dashboard';
    }
}
