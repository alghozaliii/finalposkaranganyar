<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        //role= 1.verifikator, 2.owner, 3.employee
        Role::insert([
            ['name' => 'verifikator'],
            ['name' => 'owner'],
            ['name' => 'employee'],
        ]);
    }
}

