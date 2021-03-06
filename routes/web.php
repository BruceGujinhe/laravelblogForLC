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

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::get('/', function () {
    return redirect('/blog');
});
Route::get('blog', 'BlogController@index');
Route::get('blog/{id}', 'BlogController@showArticle');

Route::resource('user/article', 'ArticleController', ['except' => 'show']);
Route::resource('user/tag', 'TagController', ['except' => 'show']);

Route::resource('comment','CommentController');

Route::get('profile', 'UserController@profile')->name('profile');
Route::post('profile', 'UserController@updateProfileImg')->name('profile');

