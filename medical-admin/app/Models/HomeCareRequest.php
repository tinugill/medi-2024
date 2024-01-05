<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCareRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'care_id',
        'procedure_id',
        'date',
        'id_proof',
        'type',
        'book_for',
        'qty',
        'price',
        'address',
        'city',
        'pincode',
        'payment_id',
        'status',
        'is_deleted'
    ];
}
