<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Role,
    Permission
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     

        Role::insert([
            ['name'=>'user','slug'=>'user'],
            ['name'=>'sonu11','slug'=>'sonu11'],
        ]);

        Permission::insert([
            ['name'=>'Add Post','slug'=>'modules.add'],
            ['name'=>'Delete Post','slug'=>'modules.delete'],
        ]);


    }
}