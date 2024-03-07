<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
    ];

    private $roles = [
        'superadmin',
        'admin',
        'user'
    ];


    public function run(): void
    {

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin@gmail.com')
        ]);

        $permissions = Permission::pluck('id', 'id')->all();

        foreach ($this->roles as $role){

            if ($role === 'superadmin'){

                $role = Role::create(['name' => $role]);
                $role->syncPermissions($permissions);
                $user->assignRole([$role->id]);

            }else{

                $role = Role::create(['name' => $role]);
            }


        }


    }
}
