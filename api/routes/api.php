<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FolderController;

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
require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->get('auth/user', function (Request $request) {
    return response()->json(UserResource::make($request->user()));
});

Route::middleware(['auth:sanctum'])->prefix('folders')->group(function() {
    Route::get('/', [FolderController::class, 'index']);
    Route::get('/{folder}', [FolderController::class, 'show']);
    Route::post('/store', [FolderController::class, 'store']);
    Route::put('/update/{folder}', [FolderController::class, 'update']);
    Route::delete('/delete/{folder}', [FolderController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->prefix('items')->group(function() {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/{item}', [ItemController::class, 'show']);
    Route::post('/store', [ItemController::class, 'store']);
    Route::put('/update/{item}', [ItemController::class, 'update']);
    Route::delete('/delete/{item}', [ItemController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->prefix('csv')->group(function() {
    Route::get('/export', [CsvController::class, 'export']);
    Route::post('/import', [CsvController::class, 'import']);
});