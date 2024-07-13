<?php

namespace App\Services;

use App\Models\User;
use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function createToken(User $user)
    {
        return $user->createToken(config('tokens.user_token'))->accessToken;
    }

    public function setRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|in:user,landlord',
        ]);

        if ($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->first()
            ]);
        }

        $role = $request->input('role');
        $user = User::create([
            'role' => $role,
        ]);

        return response()->json([
            'message' => 'Role set successfully',
            'user_id' => $user->id
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:20|unique:users'
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->save();

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return [
                'auth_error' => 'Authentication failed',
                'errors' => ['Invalid credentials'],
            ];
        }

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}