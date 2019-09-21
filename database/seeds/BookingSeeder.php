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

        // $origins = [
        //     'user',
        //     'admin',
        // ];

        // $status = [
        //     'pending', 'open', 'closed', 'reject', 'error'
        // ];

        // $faker = \Faker\Factory::create('ms_MY');
        // ini_set('memory_limit', '50G');
        // \Eloquent::reguard();
        // $this->command->info('Booking Seed');

        //  $users = \App\Models\User::with('roles')->role('general_user')->get();
        //  $admins = \App\Models\User::with('roles')->role('administrator')->get();
        // //$expertise = \App\Models\Expertise::all();
        // //$languages =\App\Models\Language::all();

        // //bookings created by user
        // foreach ($users as $user) {
        //     $translator = \App\Models\User::with('roles')->role('translator')->inRandomOrder()->get()->first();
        //     //language based on translator's language
        //     $language = $translator->languages()->inRandomOrder()->get()->first();
        //     //expertise based on translator's expertise
        //     $expertise = $translator->expertises()->inRandomOrder()->get()->first();

        //     $booking  = \App\Models\Booking::updateOrCreate([
                
        //         'start_call_at' =>$faker->datetime(),
        //         'end_call_at' =>$faker->time(),
        //         'booking_fee' => mt_rand(0,100),
        //         'call_duration' => mt_rand(1,60),
        //         'end_call' => $faker->time(),
        //         'type' =>mt_rand(0,1),
        //         'status' =>mt_rand(0,1),
        //         'notes' => $faker->sentence(6,true),
        //         'language_id' => $language->id,
        //         'translator_id' => $translator->id,
        //         'origin_id' => $user->id,
        //         'expertise_id' => $expertise->id,
        //         'requester_id' => $user->id
        //     ]);               
            
        // }
    
        // //bookings created by admin
        // foreach ($admins as $admin) {
        //     $users = \App\Models\User::with('roles')->role('general_user')->inRandomOrder()->get()->first();
        //     $translator = \App\Models\User::with('roles')->role('translator')->inRandomOrder()->get()->first();
        //     //language based on translator's language
        //     $language = $translator->languages()->inRandomOrder()->get()->first();
        //     //expertise based on translator's expertise
        //     $expertise = $translator->expertises()->inRandomOrder()->get()->first();

        //     $booking  = \App\Models\Booking::updateOrCreate([
                
        //         'start_call_at' =>$faker->datetime(),
        //         'end_call_at' =>$faker->datetime(),
        //         'booking_fee' => mt_rand(0,100),
        //         'end_call' => $faker->time(),
        //         'type' =>mt_rand(0,1),
        //         'status' =>mt_rand(0,3),
        //         'notes' => $faker->sentence(6,true),
        //         'language_id' => $language->id,
        //         'translator_id' => $translator->id,
        //         'origin_id' => $admin->id,
        //         'expertise_id' =>$expertise->id,
        //         'requester_id' => $users->id
        //     ]);
                         
        // } 
            
        // $users = \App\Models\User::all();
        // foreach ($origins as $origin) {
        //     for ($i = 0; $i < 10; $i++) {
        //         $booking  = \App\Models\Booking::updateOrCreate([
        //             'origin' => $origin,
        //             'booking_date' =>$faker->date(),
        //             'booking_time' =>$faker->time(),
        //             //'call_duration' =>,
        //             'end_call' => $faker->time(),
        //             'notes' => $faker->sentence(6,true),
        //             'language' => $faker->languageCode,
        //             //'translator_id' => rand(1,100),
        //             'origin_id' => mt_rand(1,$users->count()),
        //             'expertise_id' =>rand(1,7),
        //             'status'=> rand(0,1),
        //             'type' => rand(0,1),
        //             // 'status_id' => rand(1,100),
        //         ]);
        //                        
        //     }
        // }
    }
}
