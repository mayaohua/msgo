<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use EasyWeChat\Factory;

class AddWebEnd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // $path = $request->server('REQUEST_URI');
        // $path_no = $request->path();
        // if($path[strlen($path)-1] != '/'){
        //     $path_new = $path_no.'/?r=1';
        //     $url = str_replace($path_no,$path_new,$request->getRequestUri());
        //     // dd($url);
        //     return redirect($url);
        // }
        // return $next($request);
    }
}
