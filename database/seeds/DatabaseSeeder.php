<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ExpertiseSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(LanguageUserSeeder::class); 
        $this->call(BookingSeeder::class); 
        $this->call(NotificationSeeder::class);         
        $this->call(FeeSeeder::class);
    }
}
