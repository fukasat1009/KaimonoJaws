<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_image',
    ];

    /** リレーション(従属関係) */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
