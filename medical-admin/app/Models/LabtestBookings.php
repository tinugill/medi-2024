<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabtestBookings extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lab_id', 
        'is_home_collection',
        'is_home_delivery',
        'is_ambulance',
        'price',
        'h_c_price',
        'ambulance_price',
        'address',
        'payment_id',
        'report_file',
        'delivery_boy',
        'sample_collector',
        'is_completed',
        'is_deleted'
    ];
}
