<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

use Closure;

class CheckBlocked
{
    /**
     * Handle an incoming request. Check if user blocked
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Redis::get("intruder-".$request->ip()) > 2) {
            return new Response('You are blocked');
        }
        return $next($request);
    }
}
