<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'owner_name',
        'email',
        'mobile',
        'owner_id',
        'partner_name',
        'partner_id',
        'image',
        'banner',
        'about',
        'registration_certificate',
        'gstin',
        'tin',
        'gstin_proof',
        'tin_proof',
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
}
