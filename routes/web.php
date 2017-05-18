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

Route::prefix('admin')->group(function() 
{
	Route::get('/login', 'AdminLoginController@showLoginForm') -> name('admin.login');
	Route::post('/login', 'AdminLoginController@login') -> name('admin.login.submit');
	Route::get('/article/list', 'AdminCommandController@showArticleList') -> name('admin.article.list');
	Route::get('/article/{id}', 'AdminCommandController@editArticle') -> name('edit.article');
	Route::post('/article/{id?}', 'AdminCommandController@saveArticle') -> name('save.article');
	Route::get('/comments', 'AdminCommandController@showComments') -> name('admin.comments');
	Route::post('/comments', 'AdminCommandController@delComment') -> name('admin.delete.comment');
	Route::get('/users', 'AdminCommandController@showUsers') -> name('admin.users');
	Route::post('/users', 'AdminCommandController@banUser') -> name('admin.ban.user');
	Route::get('/', 'AdminController@index') -> name('admin.dashboard');
});


