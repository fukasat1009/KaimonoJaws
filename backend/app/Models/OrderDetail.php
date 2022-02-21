<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'cart_id',
        'quantitiy',
        'total_price',
        'preferred_date',
    ];

    /** リレーション(従属関係) */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

}
