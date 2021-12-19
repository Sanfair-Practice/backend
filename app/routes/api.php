<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VariantController;
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

Route::middleware('auth:sanctum')->group(static function () {
    Route::resource('chapter', ChapterController::class, ['only' => ['index']]);
    Route::resource('section', SectionController::class, ['only' => ['index']]);

    Route::resource('user', UserController::class, ['except' => ['destroy']]);
    Route::resource('user.training', TrainingController::class, ['only' => ['index', 'store', 'show',]])
        ->scoped();
    Route::resource('user.training.variant', VariantController::class, ['only' => ['update', 'show']])
        ->scoped();
    Route::prefix('/user/{user}')->name('user.')->group(static function () {
        Route::prefix('/training/{training}')->name('training.')->group(static function () {
            Route::prefix('/variant/{variant}')->name('variant.')->group(static function () {
                Route::post('/question/{question}/answer', [VariantController::class, 'answer'])
                    ->setBindingFields(['user' => null, 'training' => null, 'variant' => null, 'question' => null])
                    ->name('question.answer');
            });
        });
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(static function () {
    Route::get('/login', [AuthController::class, 'status']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
