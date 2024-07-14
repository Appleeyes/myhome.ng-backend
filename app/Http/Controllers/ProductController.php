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
     *              @OA\Property(property="error", type="string", example="No recommended product found"),
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
     *              @OA\Property(property="error", type="string", example="No popular product found"),
     *          ),
     *      ),
     * )
     */
    public function getPopularProduct()
    {
        return $this->productService->getPopularProduct();
    }
}
