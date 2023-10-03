<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeLayoutImage extends Model
{
    use HasFactory;
    
    protected $fillable = ['filename', 'forest_id'];
    
    public function treeImage()
    {
        return $this->belongsTo('App\Models\Forest');
    }
}