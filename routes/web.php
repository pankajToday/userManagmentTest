<?php

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

Route::get('/', 'AppHomeController@index')->name('index');

Route::get('/add-new-user', 'AppHomeController@addNewUserShow')->name('addNewShow');
Route::post('/add-new-user', 'AppHomeController@storeUser')->name('storeUser');
/*Route::get('/edit-user', 'AppHomeController@editUserShow')->name('editShow');*/
Route::post('/delete-user', 'AppHomeController@destroyUser')->name('destroyUser');
