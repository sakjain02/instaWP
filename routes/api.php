<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\v1\ApiController;

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

Route::prefix('/v1')->middleware(['auth:api'])->group(function() {
    Route::post('/add-money', [ApiController::class, 'addMoney']);
    Route::post('/buy-cookie', [ApiController::class, 'buyCookie']);
});