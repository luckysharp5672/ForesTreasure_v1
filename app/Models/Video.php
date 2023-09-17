<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    
    protected $fillable = ['filename', 'forest_id'];
    
    public function forestVideo()
    {
        return $this->belongsTo('App\Models\Forest');
    }
}
