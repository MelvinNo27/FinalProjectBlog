<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            [
                'id' => 1,
                'admin_id' => 4,
                'topic_id' => 3,
                'desc' => '🎉 Congratulations IICT Dinos 🎉 It\'s an honor to ...',
                'save_count' => 1,
                'image' => '67da9a94e2cec_482244272_679385254421597_5948270408...',
                'created_at' => '2025-03-19 16:51:08',
                'updated_at' => '2025-03-19 16:53:42'
            ],
            [
                'id' => 2,
                'admin_id' => 10,
                'topic_id' => 3,
                'desc' => 'Shout Out ko kay Jomil Congrats',
                'save_count' => 0,
                'image' => '885f3e1e6bdd9789a9c617b0184bb2f6.jpg',
                'created_at' => '2025-03-19 16:59:08',
                'updated_at' => '2025-03-19 16:59:08'
            ],
            [
                'id' => 3,
                'admin_id' => 11,
                'topic_id' => 4,
                'desc' => 'ACES TAGUM def. USEP DAVAO, 21-12.',
                'save_count' => 0,
                'image' => '67da9e2d5c0a7_482030071_677880247905431_6748652356...',
                'created_at' => '2025-03-19 17:06:29',
                'updated_at' => '2025-03-19 17:06:29'
            ],
            [
                'id' => 4,
                'admin_id' => 12,
                'topic_id' => 2,
                'desc' => 'qqqqqyuyuy',
                'save_count' => 0,
                'image' => '78f7777a5f35see8619f8290231fe108b.jpg',
                'created_at' => '2025-03-19 17:12:17',
                'updated_at' => '2025-03-19 17:12:29'
            ]
        ]);
    }
}
