<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert
        ([
            [
                'name' => 'Administrator',
                'email' => 'admin@ccsi.com',
                'password' => bcrypt('admin'),
                'pix_path' => 'dist\img\fsociety-mask-elliot.jpg',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Troy Joseph Gayod',
                'email' => 't.gayod@ccsi.com',
                'password' => bcrypt('credit'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Jorlan Aguinaldo',
                'email' => 'j.aguinaldo@ccsi.com',
                'password' => bcrypt('credit'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Jericho Rosales',
                'email' => 'dispatcher@ccsi.com',
                'password' => bcrypt('dispatcher'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Roxanne Miranda',
                'email' => 'r.miranda@ccsi.com',
                'password' => bcrypt('ao'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Joy Mondragon',
                'email' => 'j.mondragon@ccsi.com',
                'password' => bcrypt('ao'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Redmark Camatoy',
                'email' => 'srao@ccsi.com',
                'password' => bcrypt('srao'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Migs Castillo',
                'email' => 'management@ccsi.com',
                'password' => bcrypt('management'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'TFS',
                'email' => 'tfs@ccsi.com',
                'password' => bcrypt('client'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Billing',
                'email' => 'billing@ccsi.com',
                'password' => bcrypt('billing'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ],
            [
                'name' => 'Marketing',
                'email' => 'marketing@ccsi.com',
                'password' => bcrypt('marketing'),
                'pix_path' => '',
                'branch' => 25,
                'archive' => 'False'
            ]
        ]);
    }
}
