<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Register a new user with the provided information.",
     *      operationId="userRegister",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *              @OA\Property(property="phone_number", type="string", example="1234567890"),
     *              @OA\Property(property="password", type="string", example="password123"),
     *              @OA\Property(property="password_confirmation", type="string", example="password123"),
     *              @OA\Property(property="role", type="string", example="tenant"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="User registered successfully"),
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
        $result = $this->authService->register($request);

        if (isset($result['error'])) {
            return response()->json([
                'message' => 'Validation failed',
                'data' => ['errors' => $result['error']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $result,
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      tags={"Auth"},
     *      summary="Authenticate a user",
     *      description="Authenticate a user with the provided email and password",
     *      operationId="userLogin",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User authenticated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User authenticated successfully"),
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
        $result = $this->authService->login($request->only('email', 'password'));

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
            'message' => 'user authenticated successfully',
            'data' => $result,
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      tags={"Auth"},
     *      summary="Logout a user",
     *      description="Logout a user and revoke the access token",
     *      operationId="userLogout",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Logout successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Logout successful"),
     *          ),
     *      ),
     * )
     */
    public function logout(Request $request)
    {
        return $this->authService->logout($request->user());
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/user/{user}",
     *     summary="Delete a user",
     *     description="Deletes a user by ID",
     *     operationId="deleteUser",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     * )
     */
    public function deleteUser($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], Response::HTTP_OK);
    }
}