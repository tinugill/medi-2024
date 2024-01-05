<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'owner_name',
        'email',
        'mobile',
        'public_number',
        'type_of_user',
        'image',
        'banner',
        'about',
        'registration_certificate',
        'gstin',
        'aadhar',
        'gstin_proof',
        'aadhar_proof',
        'latitude',
        'longitude',
        'address',
        'city',
        'pincode',
        'slug',
        'country',
        'name_on_bank',
        'bank_name',
        'branch_name',
        'ifsc',
        'ac_no',
        'ac_type',
        'micr_code',
        'pan_no',
        'cancel_cheque',
        'pan_image',
        'is_deleted',
    ];

    public function ambulance_list()
    {
        return $this->hasMany(Ambulance_list::class, 'amb_id');
    }
}
