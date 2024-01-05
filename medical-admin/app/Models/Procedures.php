<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'is_deleted',
        'is_approved',
    ];
}
