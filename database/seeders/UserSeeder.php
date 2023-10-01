<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '吉井拓史',
            'email' => 'luckysharp5672@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('Hy560702'),
            'user_type_id' => 4,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'latitude' => null,
            'longitude' => null,
            'radius' => null,
        ]);
    }
}
