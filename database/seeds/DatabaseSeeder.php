<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(BillTableSeeder::class);
        $this->call(CardTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(WebUserTableSeeder::class);
    }
}
