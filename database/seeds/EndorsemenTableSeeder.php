<?php

use Illuminate\Database\Seeder;

class EndorsemenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 500; $i++) {
            App\Endorsement::create
            ([
                'date_endorsed' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'time_endorsed' => $faker->time($format = 'H:i:s', $max = 'now'),
                'date_due' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'time_due' => $faker->time($format = 'H:i:s', $max = 'now'),
                'account_name' => $faker->name,
                'cobor_name' => $faker->name,
                'address' => $faker->address,
                'provinces' => str_random(15),
                'requestor_name' => $faker->name,
                'type_of_loan' => str_random(6),
                'type_of_request' => str_random(6),
                'internal_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'internal_time' => $faker->time($format = 'H:i:s', $max = 'now')
            ]);
        }
    }
}
