<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'order_id',
        'item_id',
        'item_type',
        'price',
        'discount',
        'qty',
        'payment_id',
        'req_date',
        'record_image',
        'is_completed',
        'is_deleted'
    ];
}
