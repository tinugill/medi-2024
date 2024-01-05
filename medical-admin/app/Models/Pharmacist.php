<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hospital;

class Pharmacist extends Model
{
    use HasFactory;

    protected $fillable=[
            'name',
            'hospital_id',
            'email',
            'mobile',
            'address',
            'city',
            'pincode',
            'country',
            'latitude',
            'longitude',
            'password',
            'image',
            'banner_image',
            'is_deleted'
    ];

    public function hospital(){
        return $this->belongsTo(Hospital::class,'hospital_id');
    }
}
