<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'id_proof',
        'image',
        'dob',
        'gender',
        'is_consent',
        'c_relationship',
        'c_relationship_proof',
        'consent_with_proof',
        'current_complaints_w_t_duration',
        'marital_status',
        'religion',
        'occupation',
        'dietary_habits',
        'last_menstrual_period',
        'previous_pregnancy_abortion',
        'vaccination_in_children',
        'residence',
        'height',
        'weight',
        'pulse',
        'b_p',
        'temprature',
        'blood_suger_fasting',
        'blood_suger_random',
        'history_of_previous_diseases',
        'history_of_allergies',
        'history_of_previous_surgeries_or_procedures',
        'significant_family_history',
        'history_of_substance_abuse',
        'is_deleted'
    ];
}
