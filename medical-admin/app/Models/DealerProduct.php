<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'dealer_id',
        'item_name',
        'company',
        'image',
        'image_2',
        'image_3',
        'image_4',
        'description',
        'mrp',
        'discount',
        'delivery_charges',
        'is_rent',
        'rent_per_day',
        'pack_size',
        'security_for_rent',
        'delivery_charges_for_rent',
        'manufacturer_address',
        'category_id',
        'is_prescription_required',
        'status',
        'is_deleted'
    ];
}
