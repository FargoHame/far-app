<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class SetAwcCookie
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
        if ($request->has('awc')) {
            Cookie::queue('awc', $request->input('awc'), 60 * 24 * 365, '/', 'example.com', true, true);
        }

        return $next($request);
    }
}
