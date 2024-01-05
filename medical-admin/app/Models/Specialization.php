<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specialities;

class Specialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'degree',
        'is_approved',
        'is_deleted'
    ];
    /**
     * Get the Specialities that owns the phone.
     */
    // public function specialities()
    // {
    //     return $this->belongsTo(Specialities::class);
    //     // OR return $this->belongsTo('App\Specialities');
    // }
}
