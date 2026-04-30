<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun untuk mas Cokomi & mas Wowo
        User::create([
            'name'     => 'Pak Cokomi',
            'email'    => 'cokomi@toko.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Mas Wowo',
            'email'    => 'wowo@toko.com',
            'password' => Hash::make('password123'),
        ]);

        $this->call(ProductSeeder::class);
    }
}