<?php

use Illuminate\Database\Seeder;

class ExpertiseSeeder extends Seeder
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
        $this->command->info('Expertise Seed');

        $array = [
            'Engineering',
            'Medicine',
            'Technology',
            'Business',
            'Fashion',
            'Travels',
            'Sports',
            ];
        foreach ($array as $arr) {
            //for ($i = 0; $i < 10; $i++) {
                $expertise  = \App\Models\Expertise::updateOrCreate([
                    'name' => $arr,
                    'is_active' => rand(0,1),
                    'slug' => str_slug($arr,'_'),
                ]);

                //$expertise->users()->sync($expertise);
            //}
        }
    }
}
