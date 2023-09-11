<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    // protected $fillable = ['type_name'];
    
    // usersテーブルとのリレーション （主テーブル側）
    public function user() {
       return $this->hasMany('App\Models\Forest');
    }
    
}
