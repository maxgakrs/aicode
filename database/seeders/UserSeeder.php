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
        // Create admin user
        User::create([
            'name' => 'ผู้ดูแลระบบ',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '0812345678',
            'address' => '123 ถนนสุขุมวิท กรุงเทพฯ 10110',
            'role' => 'admin',
        ]);

        // Create sample customers
        User::create([
            'name' => 'สมชาย ใจดี',
            'email' => 'somchai@example.com',
            'password' => Hash::make('password'),
            'phone' => '0823456789',
            'address' => '456 ถนนรัชดาภิเษก กรุงเทพฯ 10400',
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'สมหญิง รักสวย',
            'email' => 'somying@example.com',
            'password' => Hash::make('password'),
            'phone' => '0834567890',
            'address' => '789 ถนนพหลโยธิน กรุงเทพฯ 10900',
            'role' => 'customer',
        ]);
    }
}
