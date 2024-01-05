<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorMedicineAdvice extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "appointment_id",
        "medi_id",
        "doctor_id",
        "formulation",
        "name",
        "strength",
        "route_of_administration",
        "frequncy",
        "duration",
        "special_instruction",
        "is_deleted"
    ];
}
