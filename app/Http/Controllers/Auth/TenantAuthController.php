<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\TenantService;
use App\Http\Controllers\Controller;

class TenantAuthController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * @OA\Post(
     *      path="/v1/tenant/register",
     *      tags={"Auth"},
     *      summary="Register a new tenant",
     *      description="Register a new tenant with the provided information.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="John"),
     *              @OA\Property(property="email", type="string", example="Doe"),
     *              @OA\Property(property="phone_number", type="string", example="1234567890"),
     *              @OA\Property(property="password", type="string", example="password123"),
     *              @OA\Property(property="password_confirmation", type="string", example="password123"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Tenant registered successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Tenant registered successfully"),
     *              @OA\Property(property="data", type="object", @OA\Property(property="token", type="string", example="YOUR_ACCESS_TOKEN")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Validation failed"),
     *              @OA\Property(property="data", type="object", @OA\Property(property="errors", type="object")),
     *          ),
     *      ),
     * )
     */
    public function register(Request $request)
    {
        $result = $this->tenantService->register($request);

        if (isset($result['error'])) {
            return response()->json([
                'message' => 'Validation failed',
                'data' => ['errors' => $result['error']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'Tenant registered successfully',
            'data' => $result,
        ], Response::HTTP_CREATED);
    }
}