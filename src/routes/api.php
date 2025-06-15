<?php

use App\Http\Controllers\ReceiptInfoController;
use App\Http\Middleware\VerifyBearerToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test-redis', function () {
    Redis::set('test_key_again_man', 'Hello, Redis!');
    return Redis::get('test_key_again_man');  // Should return 'Hello, Redis!'
});
Route::middleware([VerifyBearerToken::class])->group(function () {
    Route::post('/receipt-info', [ReceiptInfoController::class, 'storeReceiptInfo']);
    Route::get('/receipt-info', [ReceiptInfoController::class, 'index']);
    Route::get('/receipt-info/{receipt_id}', [ReceiptInfoController::class, 'getReceiptDetails']);
    Route::post('/receipt-info/analyze', [ReceiptInfoController::class, 'analyzeReceiptImage']);
});

