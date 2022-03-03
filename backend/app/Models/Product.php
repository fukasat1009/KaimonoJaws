<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_image',
        'product_name',
        'price',
        'stock_quantity',
        'sale_satuts',
    ];

    /** リレーション(従属関係) */
    public function product_images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function carts()
    {
        return $this->belongsToMany('App\Models\Cart')->withPivot('quantity')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('quantity','total_price','requested_delivery_date')->withTimestamps();
    }
}
