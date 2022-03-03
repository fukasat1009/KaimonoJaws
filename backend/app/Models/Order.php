<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_destination_id',
        'user_id',
        'payment_method',
        'total_price',
    ];

    /** リレーション(従属関係) */
    public function delivery_destination()
    {
        return $this->belongsTo('App\DeliveryDestination');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function carts()
    {
        return $this->hasMany('App\Cart');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity','total_price','requested_delivery_date')->withTimestamps();
    }
}
