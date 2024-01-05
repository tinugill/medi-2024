<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePaymentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'from_date',
        'end_date',
        'for_count',
        'coupon',
        'order_id',
        'service_id',
        'payment_id'
    ];
}
