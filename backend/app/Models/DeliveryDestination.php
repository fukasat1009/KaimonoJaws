<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prefecture',
        'city',
        'block',
        'postal_code',
        'building',
        'room_number',
        'phone_number',
    ];

    /** リレーション(従属関係) */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
