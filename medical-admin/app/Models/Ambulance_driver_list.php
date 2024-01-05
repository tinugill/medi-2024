<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance_driver_list extends Model
{
    use HasFactory;
    protected $fillable = [
        'amb_id',
        'driver_name',
        'image',
        'liscence_no',
        'liscence_photo',
        'address',
        'mobile',
        'is_deleted',
    ];
}
