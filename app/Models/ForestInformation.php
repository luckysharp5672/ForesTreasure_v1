<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForestInformation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'forest_id', 'tree_number', 'diameter', 'height', 'arrow_height', 'volume', 'biomass', 'species', 'longitude', 'latitude'
    ];
    
    
    // Forestsテーブルとのリレーション （従テーブル側）
    public function forests() {
        return $this->belongsTo('App\Models\Forest');
    }
}