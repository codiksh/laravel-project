<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = $this->command->ask('Administrator name', 'Admin');
        $email = $this->command->ask('Administrator email', 'admin@admin.com');

        $password = $this->command->secret("Enter {$name}'s password", 'admin123');
        \App\User::updateOrCreate(['email' => $email,], [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now()
        ])->assignRole('Super Admin');
    }
}
