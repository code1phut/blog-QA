<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/app/get_tags', 'App\Http\Controllers\Admin\TagController@index');
    Route::post('/app/create_tag', 'App\Http\Controllers\Admin\TagController@store');
    Route::post('/app/update_tag/{tag}', 'App\Http\Controllers\Admin\TagController@update');
    Route::post('/app/delete_tag/{tag}', 'App\Http\Controllers\Admin\TagController@delete');
});

