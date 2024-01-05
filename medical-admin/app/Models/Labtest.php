<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labtest extends Model
{
    use HasFactory;
    protected $fillable = [
        'lab_id',
        'category_id',
        'image',
        'test_name',
        'price',
        'discount',
        'prerequisite',
        'home_sample_collection',
        'report_home_delivery',
        'ambulance_available',
        'ambulance_fee',
        'is_approved',
        'is_deleted'
    ];
}
