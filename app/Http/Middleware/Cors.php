<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        // dd(1);
        return $next($request)->header('Access-Control-Allow-Origin', 'https://open.weixin.qq.com')
            ->header('Access-Control-Allow-Methods', 'GET,POST,PUT,OPTIONS,PATCH,DELETE,HEAD')
            ->header('Access-Control-Allow-Headers', 'x-csrf-token,x-requested-with');
    }
}