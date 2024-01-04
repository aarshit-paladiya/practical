<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "user_id"    => 0,
                "first_name" => "super-admin",
                "last_name"  => "patel",
                "email"      => "superAdmin@superAdmin.com",
                "user_role"  => "super-admin"
            ],
            [
                "user_id"    => 1,
                "first_name" => "admin",
                "last_name"  => "patel",
                "email"      => "admin@admin.com",
                "user_role"  => "admin"
            ],
            [
                "user_id"    => 1,
                "first_name" => "user",
                "last_name"  => "patel",
                "email"      => "user@user.com",
                "user_role"  => "user"
            ]
        ];

        foreach ($users as $user) {
            $newUser = new User;
            $newUser->user_id = $user['user_id'];
            $newUser->first_name = $user['first_name'];
            $newUser->last_name = $user['last_name'];
            $newUser->email = $user['email'];
            $newUser->password = Hash::make(12345678);
            $newUser->mobile_number = rand(9000000000, 9999999999);
            $newUser->bod = Carbon::now();
            $newUser->age = 0;
            $newUser->profile = 'demo_profile.webp';
            $newUser->user_role = $user['user_role'];
            $newUser->save();
        }

        $length = 5; // Set the desired length of the random string
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 1; $i <= 100; $i++) {
            $randomString = substr(str_shuffle($characters), 0, $length);
            $newUser = new User;
            $newUser->user_id = 1;
            $newUser->first_name = $randomString;
            $newUser->last_name = $randomString;
            $newUser->email = 'demo' . rand(1, 99999) . '@demo.com';
            $newUser->password = Hash::make(12345678);
            $newUser->mobile_number = rand(9000000000, 9999999999);
            $newUser->bod = Carbon::now();
            $newUser->age = 0;
            $newUser->profile = 'demo_profile.webp';
            $newUser->user_role = 'user';
            $newUser->status = rand(0, 1) == 1 ? '1' : '0';
            $newUser->save();
        }

    }
}
