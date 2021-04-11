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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/app/create_tag', 'App\Http\Controllers\Admin\TagController@addTags');
Route::get('/app/get_tags', 'App\Http\Controllers\Admin\TagController@getTags');


Route::get('/new', 'App\Http\Controllers\TestController@index');

Route::any('{slug}', function () {
    return view('welcome');
});
