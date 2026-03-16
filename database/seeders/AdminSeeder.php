<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'vanduyho717@gmail.com'],
            [
                'name' => 'Hồ Văn Duy',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            ]
        );
    }
}
