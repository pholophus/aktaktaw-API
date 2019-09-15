<?php

use Illuminate\Database\Seeder;

class LanguageUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        ini_set('memory_limit', '50G');
        \Eloquent::reguard();
        $this->command->info('LanguageUser Seed');

        $users = \App\Models\User::all();
        $languages = \App\Models\Language::all();
       

        //every user has random native language
        foreach ($users as $user) {  

            $userLanguage = \App\Models\LanguageUser::updateOrCreate([
                'user_id'=> $user->id,
                'language_id' => mt_rand(1,$languages->count()),
                'language_type' => 0,
            ]);   
        }
        //random speaking language to any 20 random person
        for($i=0; $i<20; $i++)
        {
            $userLanguage = \App\Models\LanguageUser::updateOrCreate([
                'user_id'=> mt_rand(1,$users->count()),
                'language_id' => mt_rand(1,$languages->count()),
                'language_type' => 1,
            ]);

        }

        //random other language to any 20 random person
        for($i=0; $i<20; $i++)
        {
            
            $userLanguage = \App\Models\LanguageUser::updateOrCreate([
                'user_id'=> mt_rand(1,$users->count()),
                'language_id' => mt_rand(1,$languages->count()),
                'language_type' => 2,
            ]);

        }

    }
}
