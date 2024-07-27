<?php

use App\Constants\Roles;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Session\Middleware\StartSession;
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

Route::middleware(['auth:api'])->prefix('v1')->group(function () {
    Route::get('/chats', [ChatController::class, 'getChats']);
    Route::post('/chats/{chat}/messages', [ChatController::class, 'sendMessage']);
    Route::get('/chats/{chatId}', [ChatController::class, 'getChatById']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::middleware(['role:' . Roles::TENANT])->group(function () {
        Route::get('/products', [ProductController::class, 'getAllProducts']);
        Route::get('/products/recommended', [ProductController::class, 'getRecommendedProduct']);
        Route::get('/products/popular', [ProductController::class, 'getPopularProduct']);
        Route::get('/products/bookmarked', [ProductController::class, 'getBookmarkedProducts']);
        Route::get('/products/{productId}', [ProductController::class, 'getProductDetails']);
        Route::post('/contact-agent/{product}', [ChatController::class, 'startChat']);
        Route::post('/products/{productId}/bookmark', [ProductController::class, 'toggleBookmark']);
        
    });

    Route::middleware(['role:' . Roles::LANDLORD])->group(function () {
        // 
    });
});

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/{user}/send-verification-email', [VerificationController::class, 'sendEmail']);
    Route::post('/verify-email', [VerificationController::class, 'verifyEmail']);
    Route::delete('/user/{user}', [AuthController::class, 'deleteUser']);
});


Route::get('/debug-passport-config', function () {
    return [
        'private_key' => config('passport.private_key'),
        'public_key' => config('passport.public_key'),
        'private_key_file_exists' => file_exists(config('passport.private_key')),
        'public_key_file_exists' => file_exists(config('passport.public_key')),
    ];
});

