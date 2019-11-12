<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function (){
    return "aaa";
});

Route::get('/users', 'Userscontroller@index')->name('user.firstpage');

Route::post('/users', 'Userscontroller@post_sign_in');

Route::get('/users/signed_in', 'Userscontroller@signed_in');


Route::post('/users/signed_in', 'Userscontroller@post_success_signed_in');


// Authファサードのroutesメソッドを使っている
Route::get('/books/index', 'BooksController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
