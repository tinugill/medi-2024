<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PincodeMap extends Model
{
    use HasFactory;
    protected $fillable = [
        'pincode',
        'lat',
        'lng',
        'address',
        'json_info',
        'is_deleted'
    ];
}
