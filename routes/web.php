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

Route::get('/rooms/{id}/items', 'App\Http\Controllers\ItemsController@index')->name('items.index');

Route::get('/rooms/create', 'App\Http\Controllers\RoomsController@showCreateForm')->name('rooms.create');
Route::post('/rooms/create', 'App\Http\Controllers\RoomsController@create');