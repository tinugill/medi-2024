<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'pharmacy_id',
        'category_id',
        'sub_category_id',
        'formulation_id',
        'avaliblity',
        'brand_name',
        'salt_name',
        'expiry_month',
        'expiry_year',
        'expiry_type',
        'title',
        'description',
        'manufacturer_name',
        'prescription_required',
        'manufacturer_address',
        'benefits',
        'ingredients',
        'uses',
        'country_of_origin',
        'variant_name',
        'mrp',
        'discount',
        'image',
        'image_2',
        'image_3',
        'image_4',
        'strength',
        'productType',
        'slug'
    ];
}
