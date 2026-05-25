<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'user_type'          => '',
                'last_name'          => '',
                'phone'              => '',
                'code'               => '',
                'fcm_token'          => '',
                'gender'             => '',
                'sms_subscription'   => '',
                'email_subscription' => '',
            ],
        ];

        User::insert($users);
    }
}

