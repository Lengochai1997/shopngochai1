<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->path() == 'admin/setting/config-messenger') {
            return $next($request);
        }
        $attr = $request->all();
        $attr = checkRequest($attr);
        foreach ($attr as $key => $value) {
            $request[$key] = $value;
        }
        return $next($request);
    }
}
