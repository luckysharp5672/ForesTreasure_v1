<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    // user_typesテーブルとのリレーション　（従テーブル側）
    public function userType(){
        return $this->belongsTo('App\Models\UserType');
    }

    
    // forestsテーブルとのリレーション （主テーブル側）
    public function o_forests() {
       return $this->hasMany('App\Models\Forest');
    }
    
    // 林業家かどうかを判断
    public function isForester() {
        return $this->user_type_id == 3;
    }
    
    // 活動範囲内の林業家を検索
    public static function getForestersNearby($forestLatitude, $forestLongitude) {
        return User::where('user_type_id', 3)
            ->whereRaw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= radius', [$forestLatitude, $forestLongitude, $forestLatitude])
            ->get();
    }
  
    
}
