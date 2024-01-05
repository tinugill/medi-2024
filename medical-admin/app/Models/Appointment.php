<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'member_id',
        'customer_id',
        'type',
        'date',
        'time_slot',
        'address',
        'locality',
        'pincode',
        'city',
        'hospital_id',
        'doctor_id',
        'payment_id',
        'is_accepted',
        'is_deleted'
    ];
}
