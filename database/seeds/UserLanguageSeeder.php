<?php

use Illuminate\Database\Seeder;

class UserLanguageSeeder extends Seeder
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
        $this->command->info('UserLanguage Seed');

        $users = \App\Models\User::all();
        $types = \App\Models\Type::all();

        $languages = [
            "Malay" => "my", 
            "Japanese" => "jp",
            "French" => "fr",
            "German" => "de", 
            "Korean" => "kor",
            "Arabic" => "ar",
            "Chinese (Mandarin)" => "man",
            "English" => "en",
            "Italian" => "it"
        ];

        for ($i = 0; $i < 10; $i++) {  
            
            $language = array_keys($languages);
            $lang = $language[mt_rand(0,8)];
            $code = $languages[$lang];

            $userLanguage = \App\Models\UserLanguage::updateOrCreate([
                'user_id'=> mt_rand(1,$users->count()),
                'type_id'=> mt_rand(1,$types->count()),
                'language_name' => $lang,
                'language_code' => $code,
            ]);   
        }
    }
}
