<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PostInfoController;
use App\Http\Controllers\RankInfoController;
use App\Http\Controllers\ReceiptInfoController;
use App\Http\Controllers\UserInfoController;
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
Route::get('/books', [BookController::class, 'index']);
Route::post('/ranking-post', [RankInfoController::class, 'store']);
Route::get('/ranking-post/rank_info', [RankInfoController::class, 'getAllRankInfo']);
Route::get('/ranking-post/ranking_categories', [RankInfoController::class, 'getAllCategories']);
Route::get('/ranking-post/{rank_id}', [RankInfoController::class, 'index']);
Route::get('/post-info', [PostInfoController::class, 'index']);
// QUESTION: If it is a get request API, should it be index instead of show?
Route::get('/user/{id}', [UserInfoController::class, 'show']);
Route::get('/receipt-info', [ReceiptInfoController::class, 'index']);
Route::post('/receipt-info', [ReceiptInfoController::class, 'storeReceiptInfo']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/test-redis', function () {
    Redis::set('test_key_again_man', 'Hello, Redis!');
    return Redis::get('test_key_again_man');  // Should return 'Hello, Redis!'
});
