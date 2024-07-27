<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductService
{
    public function getAllProducts()
    {
        $user = auth()->user();

        $products = Product::with(['bookmarks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get()->map(function ($product) {
            $product->isBookmarked = $product->bookmarks->isNotEmpty();
            return $product;
        });

        if (!$products) {
            return response()->json([
                'message' => 'No product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], Response::HTTP_OK);
    }

    public function getRecommendedProduct()
    {
        $user = auth()->user();

        $recommendedProducts = Product::where('recommended', true)
        ->with(['bookmarks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->get()
        ->map(function ($product) {
            $product->isBookmarked = $product->bookmarks->isNotEmpty();
            unset($product->bookmarks);
            return $product;
        });

        if (!$recommendedProducts) {
            return response()->json([
                'message' => 'No recommended product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Recommended products retrieved successfully',
            'data' => $recommendedProducts
        ], Response::HTTP_OK);
    }

    public function getPopularProduct()
    {
        $user = auth()->user();

        $popularProducts = Product::where('popular', true)
        ->with(['bookmarks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->get()
        ->map(function ($product) {
            $product->isBookmarked = $product->bookmarks->isNotEmpty();
            unset($product->bookmarks);
            return $product;
        });

        if (!$popularProducts) {
            return response()->json([
                'message' => 'No popular product found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Popular product retrieved successfully',
            'data' => $popularProducts
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

    public function toggleBookmark($productId)
    {
        $user = auth()->user();
        $bookmark = Bookmark::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json([
                'message' => 'Bookmark toggled successfully',
                'isBookmarked' => false
            ], Response::HTTP_OK);
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return response()->json([
                'message' => 'Bookmark toggled successfully',
                'isBookmarked' => true
            ], Response::HTTP_OK);
        }
    }

    public function getBookmarkedProducts()
    {
        $user = auth()->user();

        $bookmarkedProducts = Bookmark::where('user_id', $user->id)
        ->with('product')
        ->get();

        return response()->json([
            'message' => 'Bookmarked retrieved successfully',
            'data' => $bookmarkedProducts,
        ], Response::HTTP_OK);
    }
}