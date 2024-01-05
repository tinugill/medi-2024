<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance_list extends Model
{
    use HasFactory;
    protected $fillable = [
        'amb_id',
        'regis_no',
        'regis_proof',
        'ambulance_type',
        'charges_per_day',
        'discount_per_day',
        'charges_per_km',
        'discount_per_km',
        'img_1',
        'img_2',
        'img_3',
        'img_4',
        'img_5',
        'img_6',
        'is_deleted',
    ];
}
