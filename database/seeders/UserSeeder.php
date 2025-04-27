<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 1,
                'is_approved' => true,
                'owner_id' => null,
                'employees_role' => 'Manager',
                'store_name' => 'John\'s Store',
                'address' => '123 Main Street',
                'nik' => '1234567890123456',
                'phone' => '081234567890',
                'ktp_photo' => 'ktp_photos/john.jpg',
                'selfie_photo' => 'selfie_photos/john_selfie.jpg',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password456'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 2,
                'is_approved' => false,
                'owner_id' => 1,
                'employees_role' => 'Cashier',
                'store_name' => 'Jane\'s Boutique',
                'address' => '456 Secondary Street',
                'nik' => '6543210987654321',
                'phone' => '089876543210',
                'ktp_photo' => 'ktp_photos/jane.jpg',
                'selfie_photo' => 'selfie_photos/jane_selfie.jpg',
            ],
        ]);
    }
}
