<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 默认配置，将会合并到各模块中
     */
    'defaults'         => [
        /*
         * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
         */
        'response_type'     => 'array',

        /*
         * 使用 Laravel 的缓存系统
         */
        'use_laravel_cache' => true,

        /*
         * 日志配置
         *
         * level: 日志级别，可选为：
         *                 debug/info/notice/warning/error/critical/alert/emergency
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log'               => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file'  => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
        ],
    ],

    /*
     * 路由配置
     */
    'route'            => [
        /*
         * 开放平台第三方平台路由配置
         */
        // 'open_platform' => [
        //     'uri' => 'serve',
        //     'action' => Overtrue\LaravelWeChat\Controllers\OpenPlatformController::class,
        //     'attributes' => [
        //         'prefix' => 'open-platform',
        //         'middleware' => null,
        //     ],
        // ],
    ],

    /*
     * 公众号
     */
    'official_account' => [
        'default' => [
            // const APPID = "wx8a1c60703631b1b4";
            // const LOGINWAY = "snsapi_base";
            // const APPSECRET = '3ec918cc8cfd9ad6ad65ec77c420217b';
            // const MCHID = '1604061293';
            // const MCHSECRET = 'Aa123413QWERTYUIOlkjhgfdsa123413';
            // const PREPAY_URL = 'https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi';
            // const notify_url = '/wx_notify';
            'app_id'  => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'wx397218daf538dc63'),         // AppID
            'secret'  => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'b9b82d96c09516fae800e6305b0b1243'),    // AppSecret
            'token'   => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'mayh'),           // Token
            'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', 'FxTEQvilKxBcafih3jggWMzPJZHOiYrjC0mV5ZhmEuz'),                 // EncodingAESKey
//
            /*
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
             * enforce_https：是否强制使用 HTTPS 跳转
             */
            'oauth'   => [
                'scopes'        => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
                'callback'      => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', env('APP_WX_URL').'/official/oauth_callback'),
                'enforce_https' => false,
            ],
        ],
    ],

    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //         'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //         'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 小程序
     */
    // 'mini_program' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
    //         'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
    //         'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 微信支付
     */
    'payment' => [
        'default' => [
            'sandbox'            => env('WECHAT_PAYMENT_SANDBOX', false),
            'app_id'             => env('WECHAT_PAYMENT_APPID', 'wx397218daf538dc63'),
            'mch_id'             => env('WECHAT_PAYMENT_MCH_ID', '1609178328'),
            'key'                => env('WECHAT_PAYMENT_KEY', '20634d4155496454fceae3d58581f514'),
            'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', '/www/wwwroot/msgo.xyz/apiclient_cert.pem'),    // XXX: 绝对路径！！！！
            'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', '/www/wwwroot/msgo.xyz/apiclient_key.pem'),      // XXX: 绝对路径！！！！
            'notify_url'         => env('APP_WX_URL').'/wechat_notify',                           // 默认支付结果通知地址
            'reback_notify_url'  => env('APP_WX_URL').'/reback_notify',
            ],
        // ...
    ],

    /*
     * 企业微信
     */
    // 'work' => [
    //     'default' => [
    //         'corp_id' => 'xxxxxxxxxxxxxxxxx',
    //         'agent_id' => 100020,
    //         'secret'   => env('WECHAT_WORK_AGENT_CONTACTS_SECRET', ''),
    //          //...
    //      ],
    // ],
];
