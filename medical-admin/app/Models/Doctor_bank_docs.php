<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_bank_docs extends Model
{
    use HasFactory;
    protected $fillable = [
        "doctor_id",
        "name",
        "bank_name",
        "branch_name",
        "ifsc",
        "ac_no",
        "ac_type",
        "micr_code",
        "cancel_cheque",
        "pan_no",
        "pan_image"
    ];
}
