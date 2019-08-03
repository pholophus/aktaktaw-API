<?php

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
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
        $this->command->info('Profile Seed');

        for ($i = 0; $i < 10; $i++) {
            $profile = \App\Models\Profile::updateOrCreate([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone_no'=> cleanPhoneNumber($faker->phoneNumber),
                'avatar_file_path' => $faker->regexify('[A-Z0-9._%+-]') . '.pdf',
                'resume_file_path' => $faker->regexify('[A-Z0-9._%+-]') . '.pdf',
                'account_balance' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
            ]);               
        }
    }
}
