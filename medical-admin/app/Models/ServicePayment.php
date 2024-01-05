<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'discount',
        'price_4',
        'discount_4',
        'price_6',
        'discount_6',
        'price_12',
        'discount_12'
    ];
}
