<?php

use App\Http\Controllers\ProductRatingController;
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

Route::apiResource('products', 'ProductController');
Route::apiResource('categories', 'CategoryController');
Route::post('/sanctum/token', 'UserTokenController');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('newsletter', [\App\Http\Controllers\NewsletterController::class, 'send'])->name('send.newsletter');

    Route::post('products/{product}/rate', [ProductRatingController::class, 'rate']);

    Route::post('products/{product}/unrate', [ProductRatingController::class, 'unrate']);

    Route::get('rating', [ProductRatingController::class, 'index']);

    Route::post('rating/{rating}/approve', [\App\Http\Controllers\ProductRatingController::class, 'approve']);
});

Route::get('exception', function () {
    throw new Exception('Soy una excepcion');
});

Route::get('/server-error', function () {
    abort(500, 'Erro 500.:-)');
});

Route::post('/auth2', 'AuthController@register');