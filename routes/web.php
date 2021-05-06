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

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

  Route::group(['middleware' => 'can:view,room'], function() {
    Route::get('/rooms/{room}/items', 'App\Http\Controllers\ItemsController@index')->name('items.index');

    Route::get('/rooms/{room}/items/create', 'App\Http\Controllers\ItemsController@showCreateForm')->name('items.create');
    Route::post('/rooms/{room}/items/create', 'App\Http\Controllers\ItemsController@create');

    Route::get('/rooms/{room}/items/{item}/edit', 'App\Http\Controllers\ItemsController@showEditForm')->name('items.edit');
    Route::post('/rooms/{room}/items/{item}/edit', 'App\Http\Controllers\ItemsController@edit');
  });

  Route::get('/rooms/create', 'App\Http\Controllers\RoomsController@showCreateForm')->name('rooms.create');
  Route::post('/rooms/create', 'App\Http\Controllers\RoomsController@create');

  Route::get('/rooms/{room}/edit', 'App\Http\Controllers\RoomsController@showEditForm')->name('rooms.edit');
  Route::post('/rooms/{room}/edit', 'App\Http\Controllers\RoomsController@edit');

  Route::post('/rooms/{room}/destroy', 'App\Http\Controllers\RoomsController@destroy')->name('rooms.destroy');
});

Auth::routes();
