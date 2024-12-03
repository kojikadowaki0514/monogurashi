<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryTagController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// ログイン後の遷移先
Route::get('/dashboard', [CategoryController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// itmesテーブルの一覧表示
Route::get('/categories/{category}', [CategoryController::class, 'showCategoryItems'])->name('categories.items');

// タグの値で検索
Route::get('/categories/{category}/items/filter', [CategoryController::class, 'filterItems'])->name('categories.items.filter');

// 全ての持ち物の検索結果を表示
Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');

// 削除のルート
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

// 持ち物登録画面へ遷移
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');

// 持ち物登録画面で入力した値をセッションに保持する
Route::post('/items/session', [ItemController::class, 'saveToSession'])->name('items.session');

Route::post('/items', [ItemsController::class, 'store'])->name('items.store');

Route::resource('items', ItemController::class);

// カテゴリーとタグの登録画面へ遷移
Route::get('/category-tag/create', [CategoryTagController::class, 'create'])->name('category-tag.create');

// カテゴリーで入力した値をセッションに保持する
Route::post('/category-tag/session', [CategoryTagController::class, 'saveToSession'])->name('category-tag.session');

// カテゴリーとタグの登録
Route::post('/category-tag/store', [CategoryTagController::class, 'store'])->name('category-tag.store');

// カテゴリーとタグの登録後の画面表示
Route::get('/items/create', [CategoryTagController::class, 'showCreatePage'])->name('items.create');

// 退会用のルート
Route::delete('/user/delete', [UserController::class, 'deleteAccount'])->name('user.delete');

// お気に入り
Route::post('/items/{item}/toggle-favorite', [ItemController::class, 'toggleFavorite'])->name('items.toggleFavorite');


require __DIR__.'/auth.php';
