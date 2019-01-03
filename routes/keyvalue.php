<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

Route::group(['prefix' => 'key-value', 'middleware' => config('keyvalue.middleware')], function () {

    Route::get('/index', 'StevenLei\LaravelKeyValue\Controllers\KeyValueController@index')->name('keyvalue.index');

    Route::get('/view/{id}', 'StevenLei\LaravelKeyValue\Controllers\KeyValueController@view')->name('keyvalue.view');

    Route::match(['GET', 'POST'], '/create', 'StevenLei\LaravelKeyValue\Controllers\KeyValueController@create')
        ->name('keyvalue.create');

    Route::match(['GET', 'POST'], '/update/{id}', 'StevenLei\LaravelKeyValue\Controllers\KeyValueController@update')
        ->name('keyvalue.update');

    Route::post('/delete/{id}', 'StevenLei\LaravelKeyValue\Controllers\KeyValueController@delete')
        ->name('keyvalue.delete');
});
