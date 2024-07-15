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
                'message' => 'No recommended product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Recommended products retrieved successfully',
            'data' => $recommendedProduct
        ], Response::HTTP_OK);
    }

    public function getPopularProduct()
    {
        $popularProduct = Product::where('popular', true)->get();
        if(!$popularProduct){
            return response()->json([
                'message' => 'No popular product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Popular product retrieved successfully',
            'data' => $popularProduct
        ], Response::HTTP_OK);
    }

    public function getProductDetails($productId)
    {
        $productDetails = Product::find($productId);

        if($productDetails){
            return response()->json([
                'message' => 'Product details retrieved successfully',
                'data' => $productDetails
            ]);
        }

        return response()->json([
            'message' => 'Product not found',
        ], Response::HTTP_NOT_FOUND);
    }
}