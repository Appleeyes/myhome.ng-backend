<?php

use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:api', 'role:' . Roles::TENANT])->prefix('v1')->group(function () {
    // 
});

Route::prefix('v1')->group(function () {
    Route::post('/set-role', [AuthController::class, 'setRole']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/{user}/send-verification-email', [VerificationController::class, 'sendEmail']);
    Route::post('/verify-email', [VerificationController::class, 'verifyEmail']);

    Route::delete('/user/{user}', [AuthController::class, 'deleteUser']);
});

Route::middleware(['auth:api', 'role:' . Roles::LANDLORD])->prefix('v1')->group(function () {
    // 
});

Route::get('/debug-passport-config', function () {
    return [
        'private_key' => config('passport.private_key'),
        'public_key' => config('passport.public_key'),
        'private_key_file_exists' => file_exists(config('passport.private_key')),
        'public_key_file_exists' => file_exists(config('passport.public_key')),
    ];
});

