<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use EasyWeChat\Factory;
use App\Models\WebUser;

class MarketAuth
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
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $userdb = WebUser::where('user_openid',$openid)->first();
        if(!$userdb){
            return redirect('/market/welcome');
        }
        return $next($request);
    }
}
