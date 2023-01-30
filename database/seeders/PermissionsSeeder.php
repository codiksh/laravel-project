<?php
namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{

    /**
     * @var array permissions
     * first-level key is group name of permission, while array that this key contains are the set of permissions under
     * that group.
     */
    public static $permissions;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::$permissions = config('permissions_data');

        $typeOfSeeding = $this->command->ask("Decide type of seeding:\n 1. Update table\n 2. Empty Table and Re-Seed table\n 3. Add New ones only\n 4. Update by key",3);

        if($typeOfSeeding == 2){
            DB::statement("SET foreign_key_checks=0");
            Permission::truncate();
            Cache::forget('spatie.permission.cache');
            DB::statement("SET foreign_key_checks=1");
        }

        $permissionKeyToSeed = '';
        if($typeOfSeeding == 4){
            $permissionKeyToSeed = $this->command->ask('What key would like to seed/update?');
        }

        foreach (self::$permissions as $groupName => $permissionsInGroup) {
            foreach ($permissionsInGroup as $permission) {
                if($typeOfSeeding == 4 && $permission['name'] != $permissionKeyToSeed)     continue;

                if($typeOfSeeding == 2){
                    //Type is 2
                    Permission::create($permission + ['group' => $groupName]);
                    $this->command->info("Permission ". $permission['name'] . " created.");
                }

                if (!Permission::where('name', $permission['name'])->exists()) {
                    Permission::create($permission + ['group' => $groupName]);
                    $this->command->info("Permission ". $permission['name'] . " created.");
                } else if(in_array($typeOfSeeding, [1,4])){
                    if ($this->command->confirm('The Permission "' . $permission['label'] . '" already exists, do you want to update it?')) {
                        Permission::where('name', $permission['name'])->update($permission + ['group' => $groupName]);
                        $this->command->info("Permission ". $permission['name'] . " updated.");
                    }
                }
            }
        }
    }
}
