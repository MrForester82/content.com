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

Route::get('/', function () {
    return view('welcome');
});

Route::get('article/list', 'IndexController@index') -> name('article.list');
Route::get('article/create', 'IndexController@add') -> name('addArticle');
Route::post('article/create', 'IndexController@store') -> name('storeArticle');
Route::get('article/{id}', 'CommentsController@index') -> name('showArticle');
Route::post('article/{id?}', 'CommentsController@addComment') -> name('addComment');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
