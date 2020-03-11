<?php

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

Route::get('/', 'PagesController@home')->name('home');
Route::redirect('/', '/books')->name('home');
//Route::get('books', 'BooksController@index')->name('books.index');
Route::get('books/category/{category}', 'CategoryController@category')->name('books.category');
//Route::get('books/create','BooksController@create')->name('books.create');
//Route::post('books/store','BooksController@store')->name('books.store');
//Route::get('books/edit/{book}','BooksController@edit')->name('books.edit');
//
//Route::get('books/{book}', 'BooksController@show')->name('books.show');
Route::get('index', 'InfoController@index')->name('info.index');

Route::resource('books', 'BooksController', ['only' => ['index', 'create', 'store', 'update', 'edit','show']]);


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

    Route::post('books/{book}/favorite', 'BooksController@favor')->name('books.favor');
    Route::delete('books/{book}/favorite', 'BooksController@disfavor')->name('books.disfavor');



});

