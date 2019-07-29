<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'administrator',
            'staff',
            'general user',
            'translator'

        ];
        $this->command->info('Seeding Roles');
        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(
                [
                    'name' => $role
                ],
                [
                    'guard_name' => 'api',
                ]
            );
        }
    }
}
