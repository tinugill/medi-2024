<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_edu extends Model
{
    use HasFactory;
    protected $fillable = [
        "doctor_id",
        "qualification_id",
        "certificate",
        "is_deleted"
    ];
}
