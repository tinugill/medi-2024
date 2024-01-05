<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'amount',
        'amount_paid',
        'amount_due',
        'currency',
        'receipt',
        'status',
        'attempts',
        'entity',
        'notes',
        'response',
        'post_date',
        'is_deleted'
    ];
}
