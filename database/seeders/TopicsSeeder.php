<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsSeeder extends Seeder
{
    public function run()
    {
        DB::table('topics')->insert([
            [
                'id' => 1,
                'name' => 'Big Day',
                'created_at' => '2025-03-19 16:49:44',
                'updated_at' => '2025-03-19 16:49:44'
            ],
            [
                'id' => 2,
                'name' => 'Intramurals 2025',
                'created_at' => '2025-03-19 16:49:50',
                'updated_at' => '2025-03-19 16:49:50'
            ],
            [
                'id' => 3,
                'name' => 'Achievement',
                'created_at' => '2025-03-19 16:50:46',
                'updated_at' => '2025-03-19 16:50:46'
            ],
            [
                'id' => 4,
                'name' => 'PSITS 2025',
                'created_at' => '2025-03-19 17:05:01',
                'updated_at' => '2025-03-19 17:05:01'
            ]
        ]);
    }
}
