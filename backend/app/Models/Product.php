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
    public function order_detail()
    {
        return $this->belongsTo('App\OrderDetail');
    }

    public function product_images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
