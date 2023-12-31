<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\Post', 'prefix' => 'posts'], function () {
    Route::post('/', 'StoreController')->name('api.posts.store');
    Route::get('/', 'IndexController')->name('api.posts.index');
    Route::get('/{post}', 'ShowController')->name('api.post.show');
    Route::patch('/{post}', 'UpdateController')->name('api.post.update');

    Route::group(['namespace' => 'Image', 'prefix' => 'images'], function () {
        Route::post('/', 'StoreController')->name('api.posts.images.store');
    });
});
