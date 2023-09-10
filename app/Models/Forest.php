<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forest extends Model
{
    use HasFactory;
    
    // usersテーブルとのリレーション （従テーブル側）
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
