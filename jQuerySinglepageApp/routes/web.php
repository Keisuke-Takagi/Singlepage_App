<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function (){
    return "aaa";
});

Route::get('/users', 'Userscontroller@index')->name('user.firstpage')->middleware('LoginCheck');
Route::post('/users', 'Userscontroller@post_sign_in');

// 新規登録
Route::get('/users/signed_in', 'Userscontroller@signed_in')->middleware('ajax_check')->middleware('LoginCheck');
Route::post('/users/signed_in', 'Userscontroller@post_success_signed_in')->middleware('ajax_check')->middleware('LoginCheck');

// listページのルーティング
Route::get('/users/list','Userscontroller@get_user_list')->middleware('list_login_check');
Route::post('/users/list','Userscontroller@post_user_list');

Route::get('/users/login', 'Userscontroller@get_login')->name('user.login_page')->middleware('LoginCheck');
Route::post('/users/logout','Userscontroller@logout');


// ajaxでログインするためのPATH
Route::post('/ajax/users/login', 'Userscontroller@post_login_ajax')->middleware('ajax_check');


// ajaxでtemplateを取得するためだけのパス
Route::get('/ajax/users/login', 'Userscontroller@get_login_ajax')->middleware('ajax_check');

Route::get('/ajax/users/registration', 'Userscontroller@get_registration_ajax')->middleware('ajax_check');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ajaxでログインしなおす
Route::post('http://singlepage_app.com/ajax/users/login_auth', 'Userscontroller@re_login_ajax');


// 後で消す
Route::get('/ajax/users/login_check', 'Userscontroller@get_login_check');
