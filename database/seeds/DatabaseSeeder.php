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
        $this->call(TypeSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserLanguageSeeder::class); 
        $this->call(NotificationSeeder::class);      
        $this->call(LanguageSeeder::class);
        $this->call(BookingSeeder::class);       
        $this->call(FeeSeeder::class);
    }
}
