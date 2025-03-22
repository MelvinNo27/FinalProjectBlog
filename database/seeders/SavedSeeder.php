<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SavedSeeder extends Seeder
{
    public function run()
    {
        DB::table('saveds')->insert([
            [
                'id' => 1,
                'user_id' => 8,
                'post_id' => 1,
                'created_at' => '2025-03-19 16:53:42',
                'updated_at' => '2025-03-19 16:53:42'
            ]
        ]);
    }
}
