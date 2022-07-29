<?php

use App\Models\Rule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_data = config('rule');
        DB::table('rules')->insert($all_data);
    }
}
