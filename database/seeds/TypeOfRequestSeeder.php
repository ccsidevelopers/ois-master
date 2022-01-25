<?php

use App\TypeOfRequest;
use Illuminate\Database\Seeder;

class TypeOfRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfRequest::insert
        ([
            [
                'type_of_request' => 'PDRN'
            ],
            [
                'type_of_request' => 'BVR'
            ],
            [
                'type_of_request' => 'EVR'
            ]
        ]);
    }
}
