<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_counsiling extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'is_approved',
        'is_deleted'
    ];
}
