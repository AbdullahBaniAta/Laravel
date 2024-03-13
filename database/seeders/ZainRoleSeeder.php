<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ZainRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new role named "zain"
        Role::create([
            'name' => 'zain',
            'guard_name' => 'web', // Specify your guard_name here
        ]);
    }
}
