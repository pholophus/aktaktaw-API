<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
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
        $this->command->info('Language Seed');

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

            $language = \App\Models\Language::updateOrCreate([
                'language_name' => $lang,
                'language_code' => $code,
                'language_type' => mt_rand(0,3),
                'language_status' => mt_rand(0,1),
            ]);

            //$languageID = \App\Models\Language::updateOrCreate([
            //    'id'=> mt_rand(1,10),
            //]);

            $language->users()->sync($language);       
        }
    }
}
