<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $name = $this->command->ask('Administrator name', 'Admin');
        $email = $this->command->ask('Administrator email', 'admin@admin.com');

        $password = $this->command->secret("Enter {$name}'s password", 'admin123');
        \App\Models\User::updateOrCreate(['email' => $email,], [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
            'uuid' => Str::uuid()->toString()
        ])->assignRole('Super Admin');
        $this->command->info('Admin Seeded successfully!');
        DB::commit();
    }
}
