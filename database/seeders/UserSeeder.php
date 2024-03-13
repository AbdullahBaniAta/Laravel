<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Input\InputOption;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create dummy users
        User::create([
            'name' => 'admin',
            'username'=>'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'demo',
            'username'=>'demo',
            'password' => Hash::make('password456'),
        ]);

        // Add more users as needed...

        $this->command->info('User seeds created successfully.');
    }
}
