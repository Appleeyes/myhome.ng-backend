<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;


class UserService
{
    public function getUserDetails()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'User details retrieved successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
}