<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->group(function() {    
    Route::get('/products', 'index');
    Route::post('/products', 'store');
    Route::get('/products/{id}',  'show');
    Route::patch('/products/{id}',  'update');
    Route::delete('/products/{id}',  'destroy');
});