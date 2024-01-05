<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specialization;

class Specialities extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'specialization_id ',
        'speciality_name',
        'image',
        'is_approved',
        'is_deleted'
    ];

    /**
     * Get the Specialization record associated with the user.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
        // OR return $this->hasOne('App\Specialization');
    }
}
