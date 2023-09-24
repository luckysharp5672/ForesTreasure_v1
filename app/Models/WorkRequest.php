<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequest extends Model
{
    use HasFactory;
    
        // テーブル名
    protected $table = 'work_requests';

    // 代入可能なカラムの指定
    protected $fillable = [
        'requester_id',
        'forest_id',
        'forester_id',
        'work_type',
        'desired_completion_date',
        'request_date',
        'approval_date',
        'completion_date'
    ];

    // リレーション定義
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function forest()
    {
        return $this->belongsTo(Forest::class, 'forest_id');
    }

    public function forester()
    {
        return $this->belongsTo(User::class, 'forester_id');
    }
}
