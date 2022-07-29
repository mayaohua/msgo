<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use EasyWeChat\Factory;

class CardAuth
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
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $config = config('wechat.official_account.default');
            $url = $request->getRequestUri();
            $return_is = substr($url,1,6) == 'market';
            if($return_is){
                $config['oauth']['callback'] = env('APP_WX_URL').'/official/oauth_callback_guanzhu';
            }
            $app = Factory::officialAccount($config);
            $user = Session::get('wechat_user');
            if(!$user) {
                Session::put('target_url', $url);
                Session::save();
                $redirectUrl = $app->oauth->scopes(['snsapi_userinfo'])->redirect();
                return $redirectUrl;
            }
            $openid = $user['original']['openid'];
            $subscribe = $app->user->get($openid)['subscribe'];
            if(!$subscribe && $return_is){
                return redirect('/official/guanzhu');
            }
            return $next($request);
        }else{
            return $next($request);
        }
        
    }
}
