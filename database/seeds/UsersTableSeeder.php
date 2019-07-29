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

        foreach ($roles as $role) {
            for ($i = 0; $i < 10; $i++) {
                $name = $faker->name;
                $temp = explode(' ', trim($name));
                $nickname = $temp[0];

                $user = \App\Models\User::updateOrCreate([
                    'email' =>  str_slug(strtolower($role->name), '_') . '_' . $i . '@example.com',
                ], [
                    'name' => $name,
                    'password' => bcrypt('secret'),
                ]);


                if (!$user->hasRole($role)) {
                    $user->assignRole($role);
                }
            }
        }
    }
}
