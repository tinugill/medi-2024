<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloodbankstock extends Model
{
    use HasFactory;
    protected $fillable = [
        'bloodbank_id',
        'component_name',
        'avialablity',
        'available_unit',
        'is_deleted'
    ];
}
