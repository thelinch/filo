<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(["name" => "administrator", "guard_name" => "api"]);
        Role::create(["name" => "diner", "guard_name" => "api"]);
    }
}
