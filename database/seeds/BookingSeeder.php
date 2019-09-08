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

         $users = \App\Models\User::with('roles')->role('general_user')->get();
         $admins = \App\Models\User::with('roles')->role('administrator')->get();
        $expertise = \App\Models\Expertise::all();
        //$languages =\App\Models\Language::all();

        foreach ($users as $user) {
            $translator = \App\Models\User::with('roles')->role('translator')->inRandomOrder()->get()->first();

            $booking  = \App\Models\Booking::updateOrCreate([
                
               // 'origin' => 'user',
                'booking_date' =>$faker->date(),
                'booking_time' =>$faker->time(),
                'booking_fee' =>'$' . mt_rand(1,50),
                'call_duration' => mt_rand(1,60) . ' mins',
                'end_call' => $faker->time(),
                'booking_type' =>mt_rand(0,1),
                'notes' => $faker->sentence(6,true),
                //'language_id' => mt_rand(1,$languages->count()),
                'translator_id' => $translator->id,
                'origin_id' => $user->id,
                'expertise_id' => mt_rand(1,$expertise->count()),
                'requester_id' => $user->id
            ]);               
            
        }
    
        foreach ($admins as $admin) {
            $users = \App\Models\User::with('roles')->role('general_user')->inRandomOrder()->get()->first();
            $translator = \App\Models\User::with('roles')->role('translator')->inRandomOrder()->get()->first();

            $booking  = \App\Models\Booking::updateOrCreate([
                
               // 'origin' => 'admin',
                'booking_date' =>$faker->date(),
                'booking_time' =>$faker->time(),
                'booking_fee' =>'$' . mt_rand(1,50),
                'call_duration' => mt_rand(1,60) . ' mins',
                'end_call' => $faker->time(),
                'booking_type' =>mt_rand(0,1),
                'notes' => $faker->sentence(6,true),
                //'language_id' => mt_rand(1,$languages->count()),
                'translator_id' => $translator->id,
                'origin_id' => $admin->id,
                'expertise_id' => mt_rand(1,$expertise->count()),
                'requester_id' => $users->id
            ]);               
            
        }
    }
}
