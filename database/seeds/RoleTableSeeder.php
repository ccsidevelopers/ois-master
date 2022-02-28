<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert
        ([
            [
                'name' => 'Administrator'
            ],
            [
                'name' => 'Dispatcher'
            ],
            [
                'name' => 'Account Officer'
            ],
            [
                'name' => 'Credit Investigator'
            ],
            [
                'name' => 'Management'
            ],
            [
                'name' => 'Client'
            ],
            [
                'name' => 'Senior Account Officer'
            ],
            [
                'name' => 'Billing'
            ],
            [
                'name' => 'Marketing'
            ]
        ]);
    }
}
