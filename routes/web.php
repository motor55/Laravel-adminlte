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


\Illuminate\Support\Facades\Auth::routes();


/*
 * Frontend Routes
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 */
Route::group(['namespace' => 'App\Http\Controllers\Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    include_route_files(__DIR__.'/backend/');
});

