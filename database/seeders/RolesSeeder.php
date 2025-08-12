<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Membuat Role Admin
        $adminRole = Role::create(['name' => 'admin']);
        
        // Membuat Role Owner
        $ownerRole = Role::create(['name' => 'owner']);
    }
}
