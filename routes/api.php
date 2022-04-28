<?php

use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/files', function (Request $request) {
        return $request->user()->files->sortBy('created_at')->all();
    });

    Route::name('files.')->group(function () {
        Route::controller(FileController::class)->group(function () {
            Route::get('/files/owner/{user}', 'getFilesByOwner')->name('by_owner');
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
        Route::get('files/download/{file}', 'download')->name('download');
        Route::get('/files/{file}', 'show')->name('show');
    });
});