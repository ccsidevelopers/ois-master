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
//        $this->call(UserTableSeeder::class);
//        $this->call(RoleTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
//        $this->call(TypeOfLoanSeeder::class);
//        $this->call(TypeOfRequestSeeder::class);
//        $this->call(RoleUserSeeder::class);
//        $this->call(ProvinceUserSeeder::class);
    }
}
