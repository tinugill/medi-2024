<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hospital;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'hospital_id',
        'owner_name',
        'owner_id',
        'partner_name',
        'partner_id',
        'pharmacist_name',
        'pharmacist_regis_no',
        'pharmacist_regis_upload',
        'gstin',
        'gstin_certificate',
        'email',
        'mobile',
        'address',
        'city',
        'pincode',
        'country',
        'latitude',
        'longitude',
        'fax',
        'password',
        'drug_liscence_number',
        'drug_liscence_file',
        'drug_liscence_valid_upto',
        'cp_name',
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
        'slug',
        'image',
        'banner_image',
        'delivery_charges_if_less',
        'delivery_charges',
        'is_deleted'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
