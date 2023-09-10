<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function store() {
        $types = ['森林所有者', '木材探索者', '林業家'];
    
        foreach ($types as $type) {
            UserType::firstOrCreate(['type_name' => $type]);
            
            return Redirect::to('/');
        }
    }
}
