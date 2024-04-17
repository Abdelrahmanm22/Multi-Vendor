<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;



Route::group([
    'middleware'=>['auth'],
    'as'=>'dashboard.',
    'prefix'=>'dashboard',
],function (){
    Route::get('/',[DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/categories/trash',[CategoriesController::class,'trash'])->name('categories.trash');
    Route::resource('/categories',CategoriesController::class);
    Route::put('/categories/{id}/restore',[CategoriesController::class,'restore'])->name('categories.restore')->where('id','\d+');
    Route::delete('/categories/{id}/force-delete',[CategoriesController::class,'forceDelete'])->name('categories.force-delete');
    Route::resource('/products',\App\Http\Controllers\Dashboard\ProductController::class);
});
