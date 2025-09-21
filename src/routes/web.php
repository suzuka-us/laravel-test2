Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/register', [ProductController::class, 'create']);
Route::post('/products/register', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/{product}/update', [ProductController::class, 'edit']);
Route::post('/products/{product}/update', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);
