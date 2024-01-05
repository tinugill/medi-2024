<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'type',
        'mobile',
        'parent_id',
        'is_deleted'
    ];
}
