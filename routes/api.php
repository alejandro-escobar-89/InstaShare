<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::name('files.')->group(function () {
        Route::controller(FileController::class)->group(function () {
            Route::get('/files/', 'store')->name('store');
            Route::post('/files', 'store')->name('store');
            Route::match(['put', 'patch'], '/files/{file}', 'update')->name('update');
            Route::delete('/files/{file}', 'destroy')->name('destroy');
        });
    });
});

Route::name('files.')->group(function () {
    Route::controller(FileController::class)->group(function () {
        Route::get('/files', 'index')->name('index');
        Route::get('/files/owner/{user}', 'getFilesByOwner')->name('byOwner');
        Route::get('files/download/{file}', 'download')->name('download');
        Route::get('/files/{file}', 'show')->name('show');
    });
});
