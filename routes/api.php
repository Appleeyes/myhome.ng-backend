<?php

use App\Constants\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceholderController;

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

Route::middleware(['auth:api', 'role:' . Roles::LANDLORD])->prefix('v1')->group(function () {
    // 
});

Route::get('/placeholder', [PlaceholderController::class, 'placeholder']);
