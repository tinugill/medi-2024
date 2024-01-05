<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hospital;

class Laboratorist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'owner_name',
        'owner_id',
        'phone_no',
        'h_c_fee',
        'h_c_fee_apply_before',
        'r_d_fee',
        'r_d_fee_apply_before',
        'ambulance_fee',
        'hospital_id',
        'email',
        'mobile',
        'about',
        'address',
        'city',
        'pincode',
        'country',
        'latitude',
        'longitude',
        'password',
        'registration_detail',
        'cp_name',
        'registration_file',
        'days',
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
        'accredition_details',
        'accredition_certificate',
        'slug',
        'image',
        'banner_image',
        'is_deleted'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
