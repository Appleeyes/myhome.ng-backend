<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type',
        'price',
        'listing_type',
        'listing_date',
        'recommended',
        'popular',
        'location',
        'image_path',
        'erf_size',
        'floor_size',
        'dues_and_levies',
        'pet_allowed',
        'bedrooms',
        'bathrooms',
        'parking_lot',
        'user_id',
    ];
}
