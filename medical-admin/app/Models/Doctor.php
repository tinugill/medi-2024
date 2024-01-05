<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'mobile',
        'type',
        'gender',
        'user_id',
        'specialization_id',
        'symptom_i_see',
        'deasies_i_treat',
        'treatment_and_surgery',
        'specialities_id',
        'degree_file',
        'working_days',
        'doctor_image',
        'l_h_image',
        'l_h_sign',
        'doctor_banner',
        'home_visit',
        'consultancy_fee',
        'home_consultancy_fee',
        'online_consultancy_fee',
        'designation',
        'about',
        'experience',
        'award',
        'memberships_detail',
        'registration_details',
        'medical_counsiling',
        'registration_certificate',
        'letterhead',
        'signature',
        'latitude',
        'longitude',
        'hospital_id',
        'address',
        'city',
        'pincode',
        'slug',
        'country',
        'address_2',
        'city_2',
        'pincode_2',
        'country_2',
        'latitude_2',
        'longitude_2',
        'is_deleted',
    ];
}
