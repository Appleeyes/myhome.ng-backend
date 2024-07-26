<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/products/recommended",
     *      tags={"Products"},
     *      summary="Get recommended products",
     *      description="Retrieve a list of recommended products.",
     *      operationId="recommendedProducts",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Recommended products retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Recommended products retrieved successfully"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No recommended product found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No recommended product found"),
     *          ),
     *      ),
     * )
     */
    public function getRecommendedProduct()
    {
        return $this->productService->getRecommendedProduct();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/products/popular",
     *      tags={"Products"},
     *      summary="Get popular products",
     *      description="Retrieve a list of popular products.",
     *      operationId="popularProducts",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Popular products retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Popular products retrieved successfully"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No popular product found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No popular product found"),
     *          ),
     *      ),
     * )
     */
    public function getPopularProduct()
    {
        return $this->productService->getPopularProduct();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/products/{productId}",
     *      tags={"Products"},
     *      summary="Get product details",
     *      description="Retrieve details of a product by its ID.",
     *      operationId="productDetails",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="productId",
     *          in="path",
     *          required=true,
     *          description="ID of the product",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Popular products retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Popular products retrieved successfully"),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No popular product found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No popular product found"),
     *          ),
     *      ),
     * )
     */
    public function getProductDetails($productId)
    {
        return $this->productService->getProductDetails($productId);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/products/{productId}/bookmark",
     *     tags={"Products"},
     *     summary="Toggle bookmark for a product",
     *     description="Add or remove a bookmark for the specified product.",
     *     operationId="toggleBookmark",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID of the product to bookmark or unbookmark",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bookmark toggled successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bookmark toggled successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized, user not authenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function toggleBookmark($productId)
    {
        return $this->productService->toggleBookmark($productId);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products/bookmarked",
     *     tags={"Products"},
     *     summary="Get all bookmarked products",
     *     description="Retrieve a list of products that the user has bookmarked.",
     *     operationId="getBookmarkedProducts",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of bookmarked products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bookmarked retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=3),
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-25T23:20:58.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-25T23:20:58.000000Z"),
     *                     @OA\Property(
     *                         property="product",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="property_type", type="string", example="Bungalow"),
     *                         @OA\Property(property="price", type="integer", example=59279927),
     *                         @OA\Property(property="listing_type", type="string", example="Gold Listing"),
     *                         @OA\Property(property="listing_date", type="string", format="date-time", example="2024-07-25T22:49:52.000000Z"),
     *                         @OA\Property(property="recommended", type="integer", example=1),
     *                         @OA\Property(property="popular", type="integer", example=0),
     *                         @OA\Property(property="location", type="string", example="Lekki Phase 1, Admirality way 1"),
     *                         @OA\Property(property="image_path", type="string", example="https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976294/myHome/l7c5weavuagtk0krdjum.png"),
     *                         @OA\Property(property="erf_size", type="integer", example=1239),
     *                         @OA\Property(property="floor_size", type="integer", example=42),
     *                         @OA\Property(property="dues_and_levies", type="integer", example=10000),
     *                         @OA\Property(property="pet_allowed", type="integer", example=1),
     *                         @OA\Property(property="bedrooms", type="integer", example=3),
     *                         @OA\Property(property="bathrooms", type="integer", example=1),
     *                         @OA\Property(property="parking_lot", type="integer", example=2),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-25T22:49:52.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-25T22:49:52.000000Z")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized, user not authenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function getBookmarkedProducts()
    {
        return $this->productService->getBookmarkedProducts();
    }
}
