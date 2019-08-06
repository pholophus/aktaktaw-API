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

        $user = \App\Models\User::all()->count();
        foreach ($origins as $origin) {
            for ($i = 0; $i < 10; $i++) {
                $booking  = \App\Models\Booking::updateOrCreate([
                    'origin' => $origin,
                    'booking_date' =>$faker->date(),
                    'booking_time' =>$faker->time(),
                    //'call_duration' =>,
                    'end_call' => $faker->time(),
                    'notes' => $faker->sentence(6,true),
                    'language' => $faker->languageCode,
                    //'translator_id' => rand(1,100),
                    'origin_id' => rand(1,$user),
                    'expertise_id' =>rand(1,7),
                    // 'type_id'=> rand(1,100),
                    // 'status_id' => rand(1,100),
                ]);               
            }
        }
    }
}
