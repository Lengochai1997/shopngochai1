<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return $next($request);
        } else {
            return redirect(asset('admin/login'));
        }
    }
}
