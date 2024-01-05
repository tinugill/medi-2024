<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital_Staff extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'hospital_id',
        'address',
        'city',
        'pincode',
        'country',
        'password',
        'image',
        'is_super',
        'is_deleted'
    ];
}
