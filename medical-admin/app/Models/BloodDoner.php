<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDoner extends Model
{
    use HasFactory;
    protected $fillable = [
        'bloodbank_id',
        'user_id',
        'name',
        'blood_group',
        'email',
        'mobile',
        'date',
        'available_in_emergency',
        'is_donated',
        'is_deleted'
    ];
}
