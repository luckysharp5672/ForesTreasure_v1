<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForestInformation extends Model
{
    use HasFactory;
    
    // Forestsテーブルとのリレーション （従テーブル側）
    public function forests() {
        return $this->belongsTo('App\Models\Forest');
    }
}