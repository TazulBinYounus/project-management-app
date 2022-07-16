<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OriginAllowPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->environment(['production'])) {
            if ($request->server('HTTP_HOST') === 'gotipath.com' || $request->server('HTTP_HOST') === 'nusratech.com') {
                return response(['Unauthorized! Origin not supported'], 401);
            }
        } else {
            return $next($request);
        }
    }
}
