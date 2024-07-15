<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     description="Product model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="property_type", type="string", example="Apartment"),
 *     @OA\Property(property="price", type="integer", example=10000000),
 *     @OA\Property(property="listing_type", type="string", example="Silver Listing"),
 *     @OA\Property(property="listing_date", type="string", format="date-time"),
 *     @OA\Property(property="recommended", type="boolean", example=true),
 *     @OA\Property(property="popular", type="boolean", example=true),
 *     @OA\Property(property="location", type="string", example="Lekki Phase 1, Admirality way"),
 *     @OA\Property(property="image_path", type="string", example="https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976292/myHome/gjbfoweby2cbrnz8qe6h.png"),
 *     @OA\Property(property="erf_size", type="string", example="1239 m2"),
 *     @OA\Property(property="floor_size", type="string", example="42 m2"),
 *     @OA\Property(property="dues_and_levies", type="integer", example=10000),
 *     @OA\Property(property="pet_allowed", type="boolean", example=true),
 *     @OA\Property(property="bedrooms", type="integer", example=2),
 *     @OA\Property(property="bathrooms", type="integer", example=2),
 *     @OA\Property(property="parking_lot", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class Product extends Model
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
