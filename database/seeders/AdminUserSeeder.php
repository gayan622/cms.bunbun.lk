<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@bunbun.lk'
            ],
            [
                'name' => 'BunBun Admin',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'cashier@bunbun.lk'
            ],
            [
                'name' => 'Cashier User',
                'password' => Hash::make('cashier123'),
                'role' => 'cashier',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'kitchen@bunbun.lk'
            ],
            [
                'name' => 'Kitchen User',
                'password' => Hash::make('kitchen123'),
                'role' => 'kitchen',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'delivery@bunbun.lk'
            ],
            [
                'name' => 'Delivery User',
                'password' => Hash::make('delivery123'),
                'role' => 'delivery',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'manager@bunbun.lk'
            ],
            [
                'name' => 'Manager User',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );
    }
}