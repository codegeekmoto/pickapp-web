<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * User auth
 */
Route::prefix('user')->group(function() {

    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/reset', 'App\Http\Controllers\Api\AuthController@resetPassword');

    Route::post('/create', 'App\Http\Controllers\Api\UserController@create');
    Route::get('/getall', 'App\Http\Controllers\Api\UserController@getAll');
    
});

