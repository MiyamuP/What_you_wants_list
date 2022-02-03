<?php

use App\Models\Want;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ホームページ
Route::get('/', [WorkController::class, 'index']);

// 欲しいものを追加
Route::post('/wants', [WorkController::class, 'store']);

// 欲しいもの更新画面
Route::post('/wantsedit/{wants}', [WorkController::class, 'edit']);

// 欲しいもの更新処理
Route::post('/wants/update', [WorkController::class, 'update']);

// 欲しいもの削除
Route::delete('/want/{want}', [WorkController::class, 'destroy']);

Auth::routes();

Route::get('/home', [WorkController::class, 'index'])->name('home');
