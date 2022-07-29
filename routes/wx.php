<?php

use Illuminate\Http\Request;

//回调入口

Route::any('/', function(){
    return '星耀互联';
});
Route::any('/wechat_notify', 'NotifyController@wechatNotify');
Route::any('/reback_notify', 'NotifyController@wechatRebackNotify');
Route::any('/bill_notify', 'NotifyController@billNotify');

Route::group(['middleware' => [],'prefix'=> '/api'],function(){
    Route::any('/js_config', 'WeChat\Bill\ApiController@getJSSDKConfig');
    Route::post('/upload', 'WeChat\Bill\ApiController@uploadImg');
    Route::any('/', function(){
        return 'wxapi';
    });
});

Route::group(['middleware' => ['CardAuth']],function(){//公众号登录认证
    Route::group(['middleware' => [],'prefix'=> '/api/card'],function(){//公众号卡号入口
        Route::any('/', 'WeChat\Card\ApiController@index');
        Route::any('/send_captcha', 'WeChat\Card\ApiController@captcha');
        Route::any('/num_select', 'WeChat\Card\ApiController@numSelect');
        Route::any('/put_order_by_number', 'WeChat\Card\ApiController@putOrderByNumber');
        Route::any('/best_nums', 'WeChat\Card\ApiController@bestNumList');
        Route::any('/index_best_num', 'WeChat\Card\ApiController@indexBestNum');
        Route::any('/put_order_by_best', 'WeChat\Card\ApiController@putOrderByBest');
        Route::post('/put_question', 'WeChat\Card\ApiController@putQuestion');
        //小程序
        Route::get('/card_list', 'WeChat\Card\ApiController@cardList');
    });

    Route::group(['middleware' => [],'prefix'=> '/card'],function(){//公众号卡号入口
        Route::get('/', 'WeChat\Card\IndexController@index');
        Route::get('/kind', 'WeChat\Card\IndexController@kind');
        Route::get('/details/{cid}', 'WeChat\Card\IndexController@details');
        Route::get('/apply_card/{id}', 'WeChat\Card\IndexController@applyCard');
        Route::get('/apply_best', 'WeChat\Card\IndexController@applyBest');
        Route::get('/bestnum', 'WeChat\Card\IndexController@bestNum');
        Route::any('/us', 'WeChat\Card\IndexController@contactUs');
        Route::any('/question', 'WeChat\Card\IndexController@question');
        Route::any('/wxapp', 'WeChat\Card\IndexController@wxapp');
        Route::any('/tests', 'WeChat\Card\IndexController@tests');
        Route::any('/qq', 'WeChat\Card\IndexController@qq');
    });
});
Route::group(['middleware' => ['WxAuth']],function(){//公众号登录认证
    
    Route::group(['middleware' => [],'prefix'=> '/api/bill'],function(){//公众号API
            //Route::any('/js_config', 'WeChat\Bill\ApiController@getJSSDKConfig');
            Route::post('/call', 'WeChat\Bill\ApiController@callList');
            Route::post('/flow', 'WeChat\Bill\ApiController@flowList');
            Route::post('/vip', 'WeChat\Bill\ApiController@vipList');
            Route::post('/record', 'WeChat\Bill\ApiController@recordList');
            Route::post('/put_question', 'WeChat\Bill\ApiController@putQuestion');
            Route::post('/wxpay', 'WeChat\Bill\PayController@billWxpay');
            Route::post('/cancelpay', 'WeChat\Bill\PayController@billCancelpay');
            Route::post('/payfail', 'WeChat\Bill\PayController@billPayFail');
            
    });

    Route::group(['middleware' => [],'prefix'=> '/bill'],function(){//公众号充值入口
        Route::get('/', 'WeChat\Bill\IndexController@index'); 
        Route::get('/vip/', 'WeChat\Bill\IndexController@vip');
        Route::get('/record/', 'WeChat\Bill\IndexController@record');
        Route::get('/flow/', 'WeChat\Bill\IndexController@flow');
        Route::any('/center/', 'WeChat\Bill\IndexController@center');
        Route::any('/question/', 'WeChat\Bill\IndexController@question');
        Route::any('/agent/', 'WeChat\Bill\IndexController@agent');
        Route::any('/apply/', 'WeChat\Bill\IndexController@apply');
        Route::any('/us/', 'WeChat\Bill\IndexController@contactUs');
    });
});

Route::group(['middleware' => [],'prefix'=> '/official'],function(){
    Route::any('/token_ver', 'WeChat\OfficialController@token_ver');//token验证
    Route::get('/set_menu', 'WeChat\OfficialController@setMenu'); //设置菜单
    Route::get('/oauth_callback', 'WeChat\OfficialController@oauth_callback'); //认证回调
    Route::get('/oauth_callback_guanzhu', 'WeChat\OfficialController@oauth_callback_guanzhu'); //认证回调
    Route::get('/guanzhu', 'WeChat\OfficialController@guanzhu'); //认证回调
    Route::get('/template_message', 'WeChat\OfficialController@templateMessage'); //模板消息
    Route::post('/has_sell_user', 'WeChat\OfficialController@has_sell_user'); //验证分销用户是否存在
});

Route::get('/market/welcome', 'WeChat\MarketController@welcome');
Route::group(['middleware' => ['WxAuth'],'prefix'=> '/market'],function(){

    Route::get('/apply', 'WeChat\MarketController@apply');

    Route::group(['middleware' => [],'prefix'=> '/api'],function(){//公众号API
        Route::any('/js_config', 'WeChat\MarketController@getJSSDKConfig');
        Route::post('/captcha', 'WeChat\MarketController@send_captcha');
        Route::post('/apply_action', 'WeChat\MarketController@applyAction');
        Route::post('/upload_base64', 'WeChat\MarketController@uploadBase64Img');
        Route::post('/tixian', 'WeChat\MarketController@tixianAction');
        Route::post('/sysn_user', 'WeChat\MarketController@sysnUser');
    });
    
    Route::group(['middleware' => ['MarketAuth']],function(){//MarketAuth 
        Route::get('/', 'WeChat\MarketController@index');
        Route::get('/tixian', 'WeChat\MarketController@tixian');
        Route::get('/shouyi', 'WeChat\MarketController@shouyi');
        Route::get('/dingdan', 'WeChat\MarketController@dingdan');
        Route::get('/tixian_list', 'WeChat\MarketController@tixian_list');
        Route::get('/zixun', 'WeChat\MarketController@zixun');
        Route::get('/wenti', 'WeChat\MarketController@wenti');
        Route::get('/client', 'WeChat\MarketController@client');
        
    });
});
