<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('users', 'UsersController@index');
    $router->get('books', 'BookController@index');
    $router->get('books/create', 'BookController@create');
    $router->post('books', 'BookController@store');
    $router->get('books/{id}/edit', 'BookController@edit');
    $router->put('books/{id}', 'BookController@update');

});
