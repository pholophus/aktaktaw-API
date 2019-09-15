<?php

use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ms_MY');
        ini_set('memory_limit', '50G');
        \Eloquent::reguard();
        $this->command->info('Fee Seed');


        for ($i=0; $i<7; $i++) {
                $arrX = array(1,5,10);
                $fee  = \App\Models\Fee::updateOrCreate([
                    'fee_name' => $faker->word,
                    'fee_duration' => rand(5,60),
                    'fee_rate' => $arrX[array_rand($arrX)],
                    'fee_status' => rand(0,1),
                ]);

                $fee->expertises()->attach($fee);
        }
    }
}
