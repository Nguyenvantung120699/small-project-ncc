<?php
Route::get('users/search', 'AdminUserController@index');

Route::get('users/index', 'AdminUserController@index')->name('users.index');
Route::get('users/create', 'AdminUserController@create');
Route::post('users/store', 'AdminUserController@store');

Route::get('users/{id}/edit', 'AdminUserController@edit');
Route::patch('users/update/{id}', 'AdminUserController@update');

Route::get('users/view/{id}', 'AdminUserController@show');
Route::delete('users/delete/{id}', 'AdminUserController@destroy');

Route::post('users/messages', 'AdminUserController@view_messages_for_user');
Route::post('users/messagesto', 'AdminUserController@view_messages_to_user');
