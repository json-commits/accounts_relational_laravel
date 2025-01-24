<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [App\Http\Controllers\AccountController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::group(['prefix' => 'account'], function () {
            Route::post('/info', [App\Http\Controllers\AccountInformationController::class, 'index']);
            Route::post('/update', [App\Http\Controllers\AccountInformationController::class, 'update']);
        });

        Route::group(['prefix' => 'address'], function () {
            Route::post('/info', [App\Http\Controllers\AddressController::class, 'index']);
            Route::post('/create', [App\Http\Controllers\AddressController::class, 'store']);
            Route::post('/show', [App\Http\Controllers\AddressController::class, 'show']);
            Route::post('/delete', [App\Http\Controllers\AddressController::class, 'destroy']);
            Route::post('/update', [App\Http\Controllers\AddressController::class, 'update']);
        });
    });
});
