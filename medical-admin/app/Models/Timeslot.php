<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Timeslot extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'day',
        'slot_interval',
        'shift1_start_at',
        'shift1_end_at',
        'shift2_start_at',
        'shift2_end_at',
        'is_deleted'
    ];

    /**
     * Get the doctor record associated with the timeslot.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
