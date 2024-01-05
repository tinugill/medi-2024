<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyCartOrderInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'order_id',
        'buy_cart_items',
        'address',
        'pincode',
        'locality',
        'city',
        'total_amount',
        'total_discount',
        'prescription',
        'delivery_boy',
        'payment_id',
        'is_completed',
        'is_deleted'
    ];
}
