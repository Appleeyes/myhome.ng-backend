<?php

use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\Auth\TenantAuthController;

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
    Route::post('/tenant/register', [TenantAuthController::class, 'register']);
});

Route::middleware(['auth:api', 'role:' . Roles::LANDLORD])->prefix('v1')->group(function () {
    // 
});
