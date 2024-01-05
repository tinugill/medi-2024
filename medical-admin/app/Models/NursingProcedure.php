<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingProcedure extends Model
{
    use HasFactory;
    protected $fillable = [
        'nursing_id',
        'title',
        'price',
        'status',
        'is_deleted',
    ];
}
