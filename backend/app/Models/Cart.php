<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /** リレーション(従属関係) */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity')->withTimestamps();
    }

    /** カートの存在チェック */
    public function cart_exist($user_id)
    {
        $exist = \App\Models\Cart::All()->where('user_id', $user_id)->first();

        if(!$exist == null){
            return true;
        } else {
            return false;
        }
    }
}
