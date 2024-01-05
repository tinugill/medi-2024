<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    protected $fillable = [
        'uid',
        'doctor_id',
        'hospital_id',
        'speciality_id',
        'illness',
        'package_name',
        'package_location',
        'hospital_name',
        'hospital_address',
        'stay_type',
        'charges_in_rs',
        'discount_in_rs',
        'charges_in_doller',
        'discount_in_doller',
        'details',
        'is_active',
        'is_deleted'
    ];
}
