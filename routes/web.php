<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switchLang'])->name('lang.switch');

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace'=>'App\Http\Controllers\Admin'], function () {
	Route::get('/', 'AdminController@index')->name('adminboard');
	Route::get('/roles/data', 'RoleController@rolesData');
	Route::resource('/roles', 'RoleController', ['except' => ['show']]);
	Route::post('/categories/changeStatus', 'CategoryController@changeStatus');
	Route::get('/categories/data', 'CategoryController@categoriesData');
	Route::resource('/categories', 'CategoryController', ['except' => ['show']]);
	Route::get('/icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
	Route::get('/maps', ['as' => 'pages.maps', 'uses' => 'PageController@maps']);
	Route::get('/notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
	Route::get('/rtl', ['as' => 'pages.rtl', 'uses' => 'PageController@rtl']);
	Route::get('/tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
	Route::get('/typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
	Route::get('/upgrade', ['as' => 'pages.upgrade', 'uses' => 'PageController@upgrade']);
	Route::resource('/user', 'UserController', ['except' => ['show']]);
	Route::resource('/products', 'ProductController', ['except' => ['update', 'show'], 'names' => ['index' => 'admin_product_index']]);
	Route::get('/product/data/{id}', 'ProductController@productData');
	Route::post('/products/{id}/update',  'ProductController@productUpdate');
	Route::get('/product/data', 'ProductController@productsData');
	Route::post('/products/{id}/deleteImg', 'ProductController@deleteImg');
	Route::get('/profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('/profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('/profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/products', 'App\Http\Controllers\ProductController', [
		'only' => ['index', 'show'],
		'names' => ['show' => 'public_product_show']
]);
Route::get('/productslist', [\App\Http\Controllers\ProductController::class, 'list'])->name('products.list');;
Route::get('/search/products', [\App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/poster/products/{imageId}', [\App\Http\Controllers\ProductController::class, 'getProductImage'])->name('products.poster');
Route::post('/order/products', [\App\Http\Controllers\ProductController::class, 'addOrder'])->name('add_order');


