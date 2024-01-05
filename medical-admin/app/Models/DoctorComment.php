<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorComment extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "appointment_id",
        "doctor_id",
        "relevent_point_from_history",
        "provisional_diagnosis",
        "investigation_suggested",
        "treatment_suggested",
        "special_instruction",
        "followup_advice",
        "prescription_reports",
        "created_at",
        "is_deleted"
    ];
}
