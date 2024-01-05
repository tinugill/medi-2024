<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabBookingInfoList extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'type',
        'order_id', 
        'status', 
        'is_deleted'
    ];
}
