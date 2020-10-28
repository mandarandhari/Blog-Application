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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/profile', 'HomeController@edit_profile')->name('edit_profile');
    Route::patch('/profile', 'HomeController@update_profile')->name('update_profile');
    Route::get('/my-posts', 'PostController@my_posts')->name('my_posts');
    Route::get('/post/add', 'PostController@create')->name('create_post');
    Route::post('/post/add', 'PostController@store')->name('save_post');
    Route::get('/post/edit/{id}', 'PostController@edit')->name('edit_post');
    Route::patch('/post/edit/{id}', 'PostController@update')->name('update_post');
    Route::delete('/post/delete/{id}', 'PostController@destroy')->name('delete_post');
});

Route::get('/posts', 'PostController@index')->name('posts');
Route::get('{post_id}/{post_url}', 'PostController@show')->name('view_post');