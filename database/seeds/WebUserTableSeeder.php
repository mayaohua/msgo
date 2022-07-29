<?php

use Illuminate\Database\Seeder;
use App\Models\WebUser;

class WebUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        WebUser::create([
            'user_name' => '彭于晏',
            'user_code' => '620525199212451210',
            'user_phone' => '19996060074',
            'user_wx_id' => 'wxsvpid',
            'user_openid' => 'ooOia6RUjLGuaewRlPVt74U5yhYw',
            'user_info' => '{"openid":"ooOia6RUjLGuaewRlPVt74U5yhYw","nickname":"别致的圈圈","sex":1,"language":"zh_CN","city":"深圳","province":"广东","country":"中国","headimgurl":"https:\/\/thirdwx.qlogo.cn\/mmopen\/vi_32\/Q0j4TwGTfTIjcK79lwZQzTRzia5WopxvlGyEf1PoO65PRibriazCwEvpK4ibJWUTvPia8hFoFQIyQQ8BN4mZgkd0uqQ\/132","privilege":[]}',
            'user_key' => 'WxSvP6',
            ]);
    }
}
