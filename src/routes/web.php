<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;







Route::get('/products', [ProductController::class, 'index'])->name('products.index');       // 商品一覧

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search'); // 検索

Route::get('/products/register', [ProductController::class, 'create'])->name('products.create'); // 登録画面表示

Route::post('/products/register', [ProductController::class, 'store'])->name('products.store'); // 商品登録

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');   // 詳細

Route::get('/products/{product}/update', [ProductController::class, 'edit'])->name('products.edit'); // 編集画面

Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
//更新

Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // 削除
