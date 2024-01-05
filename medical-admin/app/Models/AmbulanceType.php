<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceType extends Model
{
    use HasFactory;
    protected $fillable = [
        'amb_id',
        'title',
        'image', 
        'is_deleted'
    ];
}
