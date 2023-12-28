<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
                "user_id"   => 0,
                "name"      => "super-admin",
                "email"     => "superAdmin@superAdmin.com",
                "user_role" => "super-admin"
            ],
            [
                "user_id"   => 1,
                "name"      => "admin",
                "email"     => "admin@admin.com",
                "user_role" => "admin"
            ],
            [
                "user_id"   => 1,
                "name"      => "user",
                "email"     => "user@user.com",
                "user_role" => "user"
            ]
        ];

        foreach ($users as $user) {
            $newUser = new User;
            $newUser->user_id = $user['user_id'];
            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->password = Hash::make(12345678);
            $newUser->user_role = $user['user_role'];
            $newUser->save();
        }
    }
}
