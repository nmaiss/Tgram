<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\ChannelController@index');
Route::get('/action', 'App\Http\Controllers\ChannelController@action')->name('/.action');

Route::get('/add', function () {
    return view('channels.add');
});

Route::post('/add/submit', 'App\Http\Controllers\ChannelController@submit');

Route::get('/admin', 'App\Http\Controllers\ChannelController@allData')->name('admin');

Route::any('/admin/accept', 'App\Http\Controllers\ChannelController@accept');

Route::get('/admin/{id}/reject', 'App\Http\Controllers\ChannelController@reject')->name('reject-channel');

