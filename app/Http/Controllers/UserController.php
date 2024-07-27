<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/details",
     *     tags={"User"},
     *     summary="Get user details",
     *     description="Retrieve the details of the authenticated user.",
     *     operationId="getUserDetails",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="User details retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User details retrieved successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found"),
     *         ),
     *     ),
     * )
     */
    public function getUserDetails()
    {
        return $this->userService->getUserDetails();
    }
}
