<?php

use Illuminate\Http\Request;

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

Route::group(
    [
        'middleware' => ['apiWithSession'],
        'prefix' => 'urls',
        'as' => 'api.urls.',
    ],
    function () {
        Route::get('/', 'API\UrlController@getAll')->name('all');
        Route::get('own', 'API\UrlController@getOwn')->name('own');
        Route::post('/', 'API\UrlController@store')->name('store');
    }
);
