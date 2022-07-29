<?php
return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'qcloud',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => __DIR__.'/../storage/logs/easy-sms.log',
        ],
        'yunpian' => [
            'api_key' => env('YUNPIAN_API_KEY'),
        ],
        'aliyun' => [
            'access_key_id' => '',
            'access_key_secret' => '',
            'sign_name' => '',
        ],
        'qcloud' => [
            'sdk_app_id' => env('QCLOUD_APP_ID' , '1400530048'), // SDK APP ID
            'app_key' => env('QCLOUD_APP_KEY' , '775b57fb4b7fdab63dd60ee1f1a1bbee'), // APP KEY
            'sign_name' => env('QCLOUD_SIGN_NAME' , '星耀互联'), // 对应的是短信签名中的内容（非id）
        ],
    ],
];