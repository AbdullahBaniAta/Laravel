<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddZainUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-zain-user {name} {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $username = $this->argument('username');
        $password = \Hash::make($this->argument('password'));

        // Create a new user using the UserFactory

        $user = new User();
        $user->name = $name;
        $user->username = $username;
        $user->password = $password;
        $user->save();

        $role = Role::create(['name' => 'zain']);
        $user->assignRole($role);
        return 1;
    }
}
