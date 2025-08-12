<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view karyawan',
            'create karyawan',
            'update karyawan',
            'delete karyawan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $mandor = Role::firstOrCreate(['name' => 'mandor']);
        $pemilik = Role::firstOrCreate(['name' => 'pemilik']);

        $mandor->givePermissionTo($permissions);
        $pemilik->givePermissionTo('view karyawan');

        $user = User::find(9);
        if ($user) {
            $user->syncRoles([$mandor]);
        }
    }
}
