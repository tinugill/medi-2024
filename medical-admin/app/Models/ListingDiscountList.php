<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingDiscountList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'discount',
        'is_approved',
        'is_deleted'
    ];
}
