<?php

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=\App\Models\Role::all();
        $this->command->info('Seeding Roles and Permission data');
        foreach ($roles as $role) {


            $permission = \Spatie\Permission\Models\Permission::updateOrCreate([
                'name'       => $role->name . ' module',
                'guard_name' => 'api',
            ]);


            if ($role&&!$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
