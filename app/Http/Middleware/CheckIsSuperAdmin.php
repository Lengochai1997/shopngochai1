<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use App\Admin;

class CheckIsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $is_super
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminId = Auth::guard('admin')->id();
        $admin = Admin::find($adminId);
        if ($admin->is_super == 1) {
            return $next($request);
        }
        return abort(401);

    }
}
