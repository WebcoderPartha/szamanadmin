<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
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
            'password' => Hash::make('superadmin@gmail.com'),
            'status' => 1
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


        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            DB::table('blogs')->insert([
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'content' => $faker->text($maxNbChars = 500),
            ]);
        }

    }
}
