<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RankInfoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/books', [BookController::class, 'index']);
Route::post('/ranking-post', [RankInfoController::class, 'store']);
Route::get('/ranking-post/rank_info', [RankInfoController::class, 'getAllRankInfo']);
Route::get('/ranking-post/ranking_categories', [RankInfoController::class, 'getAllCategories']);
Route::get('/ranking-post/{rank_id}', [RankInfoController::class, 'index']);
