<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function (){
    return "aaa";
});

Route::get('/users', 'Userscontroller@index');

Route::post('/users', 'Userscontroller@post_sign_in');

Route::get('/users/style', 'Userscontroller@style');

// Authファサードのroutesメソッドを使っている
Route::get('/books/index', 'BooksController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
