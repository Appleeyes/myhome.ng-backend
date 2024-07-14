<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Response;

class ProductService
{
    public function getRecommendedProduct()
    {
        $recommendedProduct = Product::where('recommended', true)->get();
        if(!$recommendedProduct){
            return response()->json([
                'error' => 'No recommended product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Recommended products retrieved successfully',
            'data' => $recommendedProduct
        ], Response::HTTP_NOT_FOUND);
    }
}