<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve the user(s) you want to assign roles to
        $users = User::all();

        // Retrieve the role(s) you want to assign
        $role = Role::where('name', 'zain')->first();

        // Assign the role to user(s)
        foreach ($users as $user) {
            $user->assignRole($role);
        }
    }
}
