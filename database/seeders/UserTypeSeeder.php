<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'type_name' => '森林所有者',
        ]);
        
        UserType::create([
            'type_name' => '木材探求者',
        ]);
        
        UserType::create([
            'type_name' => '林業家',
        ]);
        
    }
}
