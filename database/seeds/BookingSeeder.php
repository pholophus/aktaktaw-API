<?php

use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $origins = [
            'user',
            'admin',
            ];
        
        $faker = \Faker\Factory::create('ms_MY');
        ini_set('memory_limit', '50G');
        \Eloquent::reguard();
        $this->command->info('Booking Seed');
        foreach ($origins as $origin) {
            for ($i = 0; $i < 10; $i++) {
                $booking  = \App\Models\Booking::updateOrCreate([
                    'origin' => $origin,
                    'booking_date' =>$faker->date(),
                    //'booking_time' =>$faker->time(),
                    //'call_duration' =>,
                    //'end_call' => ,
                    'notes' => $faker->sentence(6,true),
                    'language' => $faker->languageCode,
                    'translator_id' => numberBetween($min = 1, $max = 100),
                    'origin_id' => numberBetween($min = 1, $max = 100),
                    'expertise_id' =>numberBetween($min = 1, $max = 100),
                    'type_id'=> numberBetween($min = 1, $max = 100),
                    'status_id' => numberBetween($min = 1, $max = 100),
                ]);               
            }
        }
    }
}
