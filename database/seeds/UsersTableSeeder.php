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

        $countries = [
            'Malaysia',
            'China',
            'Vietnam',
            'Myammar',
            'Nepal',
            'India'
        ];

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
                        'user_status' => rand(0,1),
                        'translator_status' => rand(0,2),
                        'is_new' => rand(0,1),
                        'country' => $countries[rand(0, 4)],
                    ]);

                    $wallet = \App\Models\Wallet::updateOrCreate([
                        'user_id' => $user->id,
                        'amount' => rand(1,1000),
                    ]);

                    if(!$user->hasRole($role)) {
                        $user->assignRole($role);
                    }

                    if($user->hasRole('translator')) 
                    {
                        $profile = \App\Models\Profile::updateOrCreate([
                            'name' => $faker->name,
                            'phone_no'=> cleanPhoneNumber($faker->phoneNumber),
                            'avatar_file_path' => asset('uploads/defaultpicture.png'),
                            'resume_file_path' =>  asset('uploads/dummy.pdf'),
                            'user_id' => $user->id,
                        ]);

                        $media = \App\Models\Media::updateOrCreate([
                            'file_name' => 'defaultpicture.png',
                            'type' => 'Image',
                            'folder' => 'uploads',
                            'path' =>  'uploads/defaultpicture.png',
                            'mime_type' => 'image/png',
                            'user_id' => $user->id,
                        ]);
                        $media = \App\Models\Media::updateOrCreate([
                            'file_name' => 'dummy.pdf',
                            'type' => 'Resume',
                            'folder' => 'uploads',
                            'path' =>  'uploads/dummy.pdf',
                            'mime_type' => 'application/pdf',
                            'user_id' => $user->id,
                        ]);

                        $userExpertise = \App\Models\ExpertiseUser::updateOrCreate([
                            'user_id'=> $user->id,
                            'expertise_id'=> $expertises[mt_rand(0,6)]->id,
                        ]);
                        
                    }
                    else
                    {
                        $profile = \App\Models\Profile::updateOrCreate([
                            'name' => $faker->name,
                            'phone_no'=> cleanPhoneNumber($faker->phoneNumber),
                            'avatar_file_path' => asset('uploads/defaultpicture.png'),
                            'user_id' => $user->id,
                        ]);

                        $media = \App\Models\Media::updateOrCreate([
                            'file_name' => 'defaultpicture.png',
                            'type' => 'Image',
                            'folder' => 'uploads',
                            'path' =>  'uploads/defaultpicture.png',
                            'mime_type' => 'image/png',
                            'user_id' => $user->id,
                        ]);
                    }

                    
                }
            //}
        }
    }
}
