<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address', 
        'drop_address', 
        'ambulance_id', 
        'service_ambulance_id', 
        'booking_type', 
        'booking_for', 
        'payment_id', 
        'date', 
        'is_deleted',
    ];
}
