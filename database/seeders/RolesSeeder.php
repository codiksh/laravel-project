<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{

    protected $roles = [
        'Super Admin',
        'Community Member',
        'BD-Surat',
        'BD-Pune',
        'IT Admin',
        'Publisher',
        'Admin Head',
        'Team Member',
        'IT Intern',
        'HR',
        'Team Leader',
        'Designer',
        'Content Writer',
        'Poster'
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
    }
}
