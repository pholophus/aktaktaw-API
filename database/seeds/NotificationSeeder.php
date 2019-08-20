<?php

use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
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
        $this->command->info('Notification Seed');
         
                
        $bookings = \App\Models\Booking::all();
        foreach ($bookings as $booking) {
            $notification  = \App\Models\Notification::updateOrCreate([
                'title' => $faker->word,
                'description' => $faker->sentence,
                'booking_id' => $booking->id,
                'user_id' => $booking->origin_id,
            ]);
        } 
    }
}
