<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('province_user')
        ->insert([
            [
                'user_id' => 2,
                'province_id' => 25
            ],
            [
                'user_id' => 3,
                'province_id' => 25
            ],
            [
                'user_id' => 4,
                'province_id' => 25
            ],
            [
                'user_id' => 5,
                'province_id' => 25
            ],
            [
                'user_id' => 6,
                'province_id' => 25
            ],
            [
                'user_id' => 7,
                'province_id' => 25
            ],
            [
                'user_id' => 8,
                'province_id' => 25
            ],
            [
                'user_id' => 9,
                'province_id' => 25
            ],
            [
                'user_id' => 10,
                'province_id' => 25
            ],
            [
                'user_id' => 11,
                'province_id' => 25
            ]
        ]);
    }
}
