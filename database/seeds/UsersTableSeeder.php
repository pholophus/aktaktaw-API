<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        $this->command->info('User Seed');

        $roles = \App\Models\Role::all();
        $expertises = \App\Models\Expertise::all();

        foreach ($roles as $role) {
            //foreach ($expertises as $expertise) {
                for ($i = 0; $i < 10; $i++) {
                    $name = $faker->name;
                    $temp = explode(' ', trim($name));
                    $nickname = $temp[0];


                    $user = \App\Models\User::updateOrCreate([
                        'email' =>  str_slug(strtolower($role->name), '_') . '_' . $i . '@example.com',
                    ], [
                        'password' => bcrypt('secret'),
                        'social_google_id' => \Ramsey\Uuid\Uuid::uuid1()->toString(),
                        'social_facebook_id' => \Ramsey\Uuid\Uuid::uuid1()->toString(),
                        'user_status_id' => rand(0,1),
                        'translator_status_id' => rand(0,2),
                        'is_new' => rand(0,1),
                    ]);

                    $wallet = \App\Models\Wallet::updateOrCreate([
                        'user_id' => $user->id,
                        'amount' => rand(1,20),
                    ]);

                    $profile = \App\Models\Profile::updateOrCreate([
                        'name' => $faker->name,
                        'phone_no'=> cleanPhoneNumber($faker->phoneNumber),
                        'avatar_file_path' => $faker->regexify('[A-Z0-9]') . '.jpg',
                        'resume_file_path' => $faker->regexify('[A-Z0-9]') . '.pdf',
                        'wallet_id' => $wallet->id,
                        'user_id' => $user->id,
                    ]);

                    if(! $user->hasRole($role)) {
                        $user->assignRole($role);
                    }
                }
            //}
        }
    }
}
