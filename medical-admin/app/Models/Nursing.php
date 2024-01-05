<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nursing extends Model
{
    use HasFactory;
    protected $fillable = [
        'buero_id',
        'regis_type',
        'email',
        'mobile',
        'name',
        'type',
        'gender',
        'qualification',
        'image',
        'banner',
        'about',
        'experience',
        'registration_certificate',
        'id_proof',
        'degree',
        'latitude',
        'longitude',
        'address',
        'city',
        'pincode',
        'slug',
        'country',
        'part_fill_time',
        'work_hours',
        'is_weekof_replacement',
        'custom_remarks',
        'visit_charges',
        'per_hour_charges',
        'per_days_charges',
        'per_month_charges',
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
