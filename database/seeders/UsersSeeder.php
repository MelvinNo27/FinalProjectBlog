<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => '2025-03-18 02:51:09',
                'gender' => 'male',
                'role' => 'admin',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 02:51:09',
                'updated_at' => '2025-03-18 02:51:09'
            ],
            [
                'id' => 3,
                'name' => 'Try',
                'email' => 'Admin123@gmail.com',
                'email_verified_at' => null,
                'gender' => 'male',
                'role' => 'user',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:04:52',
                'updated_at' => '2025-03-18 03:04:52'
            ],
            [
                'id' => 4,
                'name' => 'Cirde',
                'email' => 'Cirdemosquito04@gmail.com',
                'email_verified_at' => null,
                'gender' => 'male',
                'role' => 'admin',
                'image' => '67da9a3193692logo_dark.png.png',
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:13:16',
                'updated_at' => '2025-03-19 16:56:13'
            ],
            [
                'id' => 5,
                'name' => 'Try',
                'email' => 'asdawd@gmail.com',
                'email_verified_at' => '2025-03-18 02:51:09',
                'gender' => 'male',
                'role' => 'user',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:17:34',
                'updated_at' => '2025-03-18 03:17:34'
            ],
            [
                'id' => 6,
                'name' => 'Trys',
                'email' => 'Trys@gmail.com',
                'email_verified_at' => '2025-03-18 03:22:58',
                'gender' => 'male',
                'role' => 'user',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:22:58',
                'updated_at' => '2025-03-18 03:22:58'
            ],
            [
                'id' => 7,
                'name' => 'Try22',
                'email' => 'Try22@gmail.com',
                'email_verified_at' => '2025-03-18 03:27:12',
                'gender' => 'male',
                'role' => 'user',
                'image' => '67d88d3a83004b97cbc5a9a34e08f2fb4c2939f52555d.jpg.png',
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:27:12',
                'updated_at' => '2025-03-18 03:29:38'
            ],
            [
                'id' => 8,
                'name' => 'ffff',
                'email' => 'ffff@gmail.com',
                'email_verified_at' => '2025-03-18 03:33:08',
                'gender' => 'male',
                'role' => 'user',
                'image' => '67daa047bab71455713386_1051139769941638_296576538206624718_n.jpg',
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-18 03:33:08',
                'updated_at' => '2025-03-19 17:15:27'
            ],
            [
                'id' => 9,
                'name' => 'Zhaira',
                'email' => 'Zhaira@gmail.com',
                'email_verified_at' => '2025-03-19 14:19:31',
                'gender' => 'male',
                'role' => 'user',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-19 14:19:31',
                'updated_at' => '2025-03-19 16:55:05'
            ],
            [
                'id' => 10,
                'name' => 'Christian',
                'email' => 'Caleo@gmail.com',
                'email_verified_at' => '2025-03-19 16:58:01',
                'gender' => 'male',
                'role' => 'user',
                'image' => '67da9cd602baf476426195_1165100511837465_4074373443336777886_n.jpg',
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-19 16:58:01',
                'updated_at' => '2025-03-19 17:00:46'
            ],
            [
                'id' => 11,
                'name' => 'Zaira Diocson',
                'email' => 'Zaira@gmail.com',
                'email_verified_at' => '2025-03-19 17:02:29',
                'gender' => 'female',
                'role' => 'admin',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-19 17:02:29',
                'updated_at' => '2025-03-19 17:03:17'
            ],
            [
                'id' => 12,
                'name' => 'uj',
                'email' => 'uj@gmail.com',
                'email_verified_at' => '2025-03-19 17:10:20',
                'gender' => 'male',
                'role' => 'user',
                'image' => null,
                'password' => Hash::make('password123'),
                'created_at' => '2025-03-19 17:10:20',
                'updated_at' => '2025-03-19 17:10:20'
            ],
        ]);
    }
}
