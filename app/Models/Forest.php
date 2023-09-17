<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forest extends Model
{
    use HasFactory;
    
    // usersテーブルとのリレーション （従テーブル側）
    public function owner() {
        return $this->belongsTo('App\Models\User');
    }
    
    // forest_infomationテーブルとのリレーション （主テーブル側）
    public function forestinfo() {
       return $this->hasMany('App\Models\ForestInformation');
    }
    
    // Videosテーブルとのリレーション　（主テーブル側）
    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }
}
