<?php

use App\Http\Controllers\Folder\FolderController;
use App\Http\Controllers\Folder\FolderNoteController;
use App\Http\Controllers\Note\NoteController;
use App\Http\Controllers\TagController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('notes')->controller(NoteController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::prefix('{id}')->group(function () {
            Route::get('/', 'show');
            Route::put('/', 'update')->withoutMiddleware('throttle:api');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('tags')->controller(TagController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::prefix('{id}')->group(function () {
            Route::put('/', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('folders')->controller(FolderController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::prefix('{id}')->group(function () {
            Route::put('/', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('folder-notes')->controller(FolderNoteController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::prefix('{id}')->group(function () {
            Route::delete('/', 'destroy');
        });
    });
});
