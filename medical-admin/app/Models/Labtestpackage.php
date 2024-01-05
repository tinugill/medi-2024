<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labtestpackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'lab_id',
        'test_ids',
        'package_name',
        'price',
        'discount',
        'home_sample_collection',
        'report_home_delivery',
        'ambulance_available',
        'ambulance_fee',
        'image',
        'is_deleted'
    ];
}
