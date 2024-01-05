<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProductPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'type',
        'image',
        'qty',
        'price',
        'address',
        'city',
        'pincode',
        'payment_id',
        'status',
        'is_deleted'
    ];
}
