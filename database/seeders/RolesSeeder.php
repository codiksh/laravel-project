<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{

    protected $roles = [
        'Super Admin',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
            if(! Role::where('name',$role)->exists()){
                Role::create(['name' => $role]);
            }
        }
        $this->command->info('Roles Seeded successfully!');
    }
}
