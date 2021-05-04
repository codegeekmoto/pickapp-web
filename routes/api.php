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



/*******************************************************************
 * AUTH
 *******************************************************************/Route::prefix('auth')->group(function() {
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/reset', 'App\Http\Controllers\Api\AuthController@resetPassword');
    Route::post('/resend-otp', 'App\Http\Controllers\Api\AuthController@resendOTP');
    Route::post('/change-password', 'App\Http\Controllers\Api\AuthController@changePassword');
});

/*******************************************************************
 * USER
 *******************************************************************/
Route::prefix('user')->group(function() {
    Route::post('/create', 'App\Http\Controllers\Api\UserController@create');

    Route::middleware('auth:api')->prefix('update')->group(function() {
        Route::post('/email', 'App\Http\Controllers\Api\UserController@updateEmail');
        Route::post('/phone', 'App\Http\Controllers\Api\UserController@updatePhone');
        Route::post('/address', 'App\Http\Controllers\Api\UserController@updateAddress');
        Route::post('/change-password', 'App\Http\Controllers\Api\UserController@changePassword');
    });    
});

/*******************************************************************
 * SELLER
 *******************************************************************/
 // Product
 Route::middleware('auth:api')->prefix('product')->group(function() {
    // Route::post('/add', 'App\Http\Controllers\Api\UserController@updateAddress');
 });

 Route::middleware('auth:api')->prefix('store')->group(function() {
    Route::post('/create', 'App\Http\Controllers\Api\StoreController@create');
 });

 Route::middleware('auth:api')->prefix('product')->group(function() {
    Route::post('/add', 'App\Http\Controllers\Api\ProductController@add');
    Route::get('/all', 'App\Http\Controllers\Api\ProductController@getAll');
 });

