<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $jobForm = [];
        // $jobForm['find_rules'] = [];
        // $jobForm['find_number'] = 10;
        // $jobForm['find_cron'] = '* * * * *';
        // Setting::create([
        //     'key' => 'jobForm',
        //     'value' => json_encode($jobForm)
        // ]);
        // $wxForm = [
        //     'zixunList'=>[],
        //     'gonggao'=>''
        // ];
        // Setting::create([
        //     'key' => 'wxForm',
        //     'value' => json_encode($wxForm)
        // ]);
        // $backForm = [
        //     'channel'=>''
        // ];
        Setting::create(['key' => 'app_profit','value' => '10']);
        Setting::create(['key' => 'user_profit','value' => '10']);
        Setting::create(['key' => 'user_app_profit','value' => '10']);

        $sellForm = [
            // 'can_sell'=>true,
            'bannerList' => [],
            'indexMsg' => '这是公告',
            'hzBanner' => 'https://test.1001020.cn/storage/uploads/2021-06-17-17-11-13.png',
            'hzText' => '汇总文字',
            'hzImg' => 'https://test.1001020.cn/storage/uploads/2021-06-17-17-09-52.jpg',
            'cardBanner' => 'https://test.1001020.cn/storage/uploads/2021-06-17-17-11-13.png',
            'cardImg' => 'https://test.1001020.cn/storage/uploads/2021-06-17-17-09-52.jpg',
            'jieshao_page'=>'<p>分销介绍页面</p><p><a href="https://test.1001020.cn/market/apply" target="_blank">加入合伙人</a></p>',
            'zixun_page'=> '<p>分销咨询页面</p>',
            'wenti_page'=>'<p>常见问题页面</p>'
        ];
        Setting::create([
            'key' => 'sellForm',
            'value' => json_encode($sellForm)
        ]);

        
    }
}
