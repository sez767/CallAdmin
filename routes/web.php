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

Route::redirect('/home', '/');
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
 * Clients management
 * */
Route::prefix('/clients')->group(function () {
    Route::get('/', [\App\Http\Controllers\ClientsController::class, 'index']);
    Route::get('/{client}', [\App\Http\Controllers\ClientsController::class, 'show']);
    Route::post('/store', [\App\Http\Controllers\ClientsController::class, 'store']);
    Route::patch('/{client}', [\App\Http\Controllers\ClientsController::class, 'update']);
    Route::post('/destroy', [\App\Http\Controllers\ClientsController::class, 'destroyMass']);
    Route::delete('/{client}/destroy', [\App\Http\Controllers\ClientsController::class, 'destroy']);
});
/*
 * Sites management
 * */
Route::prefix('/sites')->group(function () {
    Route::get('/', [\App\Http\Controllers\SitesController::class, 'index']);
    Route::get('/{sites}', [\App\Http\Controllers\SitesController::class, 'show']);
    Route::post('/store', [\App\Http\Controllers\SitesController::class, 'store']);
    Route::patch('/{sites}', [\App\Http\Controllers\SitesController::class, 'update']);
    Route::post('/destroy', [\App\Http\Controllers\SitesController::class, 'destroyMass']);
    Route::delete('/{sites}/destroy', [\App\Http\Controllers\SitesController::class, 'destroy']);
});
/*
 * Staff management
 * */
Route::prefix('/staff')->group(function () {
    Route::get('/', [\App\Http\Controllers\StaffController::class, 'index']);
    Route::get('/{staff}', [\App\Http\Controllers\StaffController::class, 'show']);
    Route::post('/store', [\App\Http\Controllers\StaffController::class, 'store']);
    Route::patch('/{staff}', [\App\Http\Controllers\StaffController::class, 'update']);
    Route::post('/destroy', [\App\Http\Controllers\StaffController::class, 'destroyMass']);
    Route::delete('/{staff}/destroy', [\App\Http\Controllers\StaffController::class, 'destroy']);
    Route::post('/invite', [\App\Http\Controllers\StaffController::class, 'invite']);
});
/*
 * Widget's sites visits
 * */
Route::prefix('/visits')->group(function () {
    Route::get('/', [\App\Http\Controllers\VisitsController::class, 'index']);
    Route::post('/gethead', [\App\Http\Controllers\VisitsController::class, 'gethead']);
    Route::post('/destroy', [\App\Http\Controllers\VisitsController::class, 'destroyMass']);
    Route::delete('/{visits}/destroy', [\App\Http\Controllers\VisitsController::class, 'destroy']);
});
/*
 * Current user
 * */
Route::prefix('/user')->group(function () {
    Route::get('/', [\App\Http\Controllers\CurrentUserController::class, 'show']);
    Route::patch('/', [\App\Http\Controllers\CurrentUserController::class, 'update']);
    Route::patch('/password', [\App\Http\Controllers\CurrentUserController::class, 'updatePassword']);
});

/*
 * File upload (e.g. avatar)
 * */
Route::post('/files/store', [\App\Http\Controllers\FilesController::class, 'store']);
/*
* Email invitation 0f new staff
*
**/
Route::get('/registration/{token}', [\App\Http\Controllers\StaffController::class, 'mailregistration'])->name('mailregistration');
/*
* Videocall
*
**/
Route::get('/videoclient', [App\Http\Controllers\VideoController::class, 'videoClient'])->name('videoClient');
Route::get('/videostaff', [App\Http\Controllers\VideoController::class, 'videoStaff'])->name('videoStaff');
Route::post('/videoended', [App\Http\Controllers\VideoController::class, 'videoEnded']);
Route::post('/videocall', [App\Http\Controllers\VideoController::class, 'videoCall']);
