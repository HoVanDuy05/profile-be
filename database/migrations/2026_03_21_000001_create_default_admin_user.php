<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'vanduyho717@gmail.com'],
            [
                'name' => 'Hồ Văn Duy',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'vanduyho717@gmail.com')->delete();
    }
};
