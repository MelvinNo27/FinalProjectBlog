<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('sessions')->insert([
            [
                'id' => 'eN7IGDj6PGtN5jlDzZx52B6o2KgFiCSEvgql5n5y',
                'user_id' => null,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDo2ZVXQVBva3JXRk1rVU...',
                'last_activity' => 1742245403
            ],
            [
                'id' => 'gBm10Ur6tNJYA4kyXidHp7Q40AqMkBTvzhdCb',
                'user_id' => null,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoRDlVNRIN0xhVnQ1Tk...',
                'last_activity' => 1742310691
            ],
            [
                'id' => 'Gu9kPTcuhK8Ktw0H9brfrabIJC0KOVmzETykM2g',
                'user_id' => 8,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoic29pR1RlUExiSGRSZ...',
                'last_activity' => 1742368758
            ],
            [
                'id' => 'Mitx7hu2ysSr3bANJOTHC4yWA3QyN5igiELt5v5t',
                'user_id' => 8,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoicZz8zRodSMWZ5cFVZ...',
                'last_activity' => 1742670641
            ],
            [
                'id' => 'UPLSoHsWmluFvJMWXDXGRKaKub30tJNxalBSYNzq',
                'user_id' => 1,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoTWVQTzJidjRBSINhTk...',
                'last_activity' => 1742310931
            ]
        ]);
    }
}
