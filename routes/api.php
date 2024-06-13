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
    Route::post('/tenant/login', [TenantAuthController::class, 'login']);
});

Route::middleware(['auth:api', 'role:' . Roles::LANDLORD])->prefix('v1')->group(function () {
    // 
});

Route::get('/db-config', function () {
    return [
        'DB_CONNECTION' => config('database.default'),
        'DB_HOST' => config('database.connections.mysql.host'),
        'DB_PORT' => config('database.connections.mysql.port'),
        'DB_DATABASE' => config('database.connections.mysql.database'),
        'DB_USERNAME' => config('database.connections.mysql.username'),
        'DB_PASSWORD' => config('database.connections.mysql.password'),
        'MYSQL_ATTR_SSL_CA' => config('database.connections.mysql.options.' . PDO::MYSQL_ATTR_SSL_CA)    
    ];
});