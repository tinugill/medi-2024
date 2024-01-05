<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloodbank extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'hospital_id',
        'email',
        'mobile',
        'address',
        'about',
        'city',
        'pincode',
        'country',
        'latitude',
        'longitude',
        'password',
        'liscence_no',
        'liscence_file',
        'cp_name',
        'days',
        'slug',
        'image',
        'banner_image',
        'is_deleted'
    ];
}
