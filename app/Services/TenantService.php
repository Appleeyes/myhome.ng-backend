<?php

namespace App\Services;

use App\Models\User;
use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantService
{
    public function createToken(User $user)
    {
        return $user->createToken(config('tokens.tenant_token'))->accessToken;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:20|unique:users'
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        $tenant = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => Roles::TENANT,
        ]);

        $token = $this->createToken($tenant);

        return [
            'tenant' => $tenant,
            'token' => $token,
        ];
    }
}