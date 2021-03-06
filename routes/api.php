<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::group(['middleware'=>['auth:sanctum']], function(){// });
// El middleware va a nivlel de controlador para exceptuar algunas rutas de autenticacion
Route::apiResource('categories', 'api\CategoryController');
Route::apiResource('products', 'api\ProductController');
Route::apiResource('rents', 'api\RentController');
Route::apiResource('news', 'api\NewController');
//User-Admin
Route::post('login', 'api\UserController@login');
Route::post('register', 'api\UserController@register');
Route::apiResource('shops', 'api\ShopController');
Route::post('logout', 'api\UserController@logout');

Route::get('rents/state/{post}','api\RentController@changeState');


// Rutas para banners y requistos 
Route::get('banners/index/{section}','api\ConfigController@indexBanners');

Route::post('banners/create','api\ConfigController@createBanner');
Route::get('banners/desactive/{id}','api\ConfigController@desactiveImageBanner');

Route::post('requireds/create','api\ConfigController@createRequired');
Route::get('requireds','api\ConfigController@getRequired');