<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
     *      path="/api/v1/tenant/register",
     *      tags={"Auth"},
     *      summary="Register a new tenant",
     *      description="Register a new tenant with the provided information.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
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
     *              @OA\Property(property="data", type="object", @OA\Property(property="errors", example="Validation failed")),
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

    /**
     * @OA\Post(
     *      path="/api/v1/tenant/login",
     *      tags={"Auth"},
     *      summary="Authenticate a tenant",
     *      description="Authenticate a tenant with the provided email and password",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Tenant authenticated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Tenant authenticated successfully"),
     *              @OA\Property(property="data", type="object", @OA\Property(property="token", type="string", example="YOUR_TOKEN")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Authentication failed"),
     *              @OA\Property(property="data", type="object", @OA\Property(property="errors", example="Authentication failed")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation failed"),
     *              @OA\Property(property="data", type="object", @OA\Property(property="errors", example="Validation failed")),
     *          ),
     *      ),
     * )
     */
    public function login(Request $request)
    {
        $result = $this->tenantService->login($request->only('email', 'password'));

        if (isset($result['error'])) {
            return response()->json([
                'message' => 'Validation failed',
                'data' => ['errors' => $result['error']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (isset($result['auth_error'])) {
            return response()->json([
                'message' => 'Authentication failed',
                'data' => ['errors' => $result['errors']],
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Tenant authenticated successfully',
            'data' => $result,
        ], Response::HTTP_OK);
    }
}