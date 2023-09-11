<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forest extends Model
{
    use HasFactory;
    
    // usersテーブルとのリレーション （従テーブル側）
    public function owner() {
        return $this->belongsTo(User::class, 'id');
    }
}
