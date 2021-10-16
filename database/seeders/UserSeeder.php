<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        //Create the default admin user
        $user = User::factory()
            ->state([
                'name' => config('app.admin_user.name'),
                'email' => config('app.admin_user.email'),
                'password' => Hash::make(config('app.admin_user.password')),
                'admin' => true,
                'theme' => 'dark',
            ])
            ->create();

        $this->command->info($user->name . ' admin account created....');
    }
}
