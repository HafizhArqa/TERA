<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PelangganUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'pelanggan@tera.com',
            ],
            [
                'username' => 'pelanggan',
                'nama'     => 'Alexandre',
                'password' => Hash::make('pelanggan123'),
                'role'     => 'Pelanggan', 
            ]
        );
    }
}
