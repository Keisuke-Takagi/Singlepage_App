<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function (){
    return "aaa";
});

Route::get('/users', 'Userscontroller@index')->name('user.firstpage');

Route::post('/users', 'Userscontroller@post_sign_in');

Route::get('/users/login', 'Userscontroller@get_login')->name('user.login_page');


Route::get('/users/signed_in', 'Userscontroller@signed_in')->middleware('ajax_check');

Route::post('/users/signed_in', 'Userscontroller@post_success_signed_in');


// listページのルーティング
Route::post('/users/list','Userscontroller@post_user_list');

Route::get('/users/list','Userscontroller@get_user_list');

Route::post('/users/logout','Userscontroller@logout');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
