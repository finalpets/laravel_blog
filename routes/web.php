<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//slug name of the parameter
//closure means go no where in the php artisan route:list 
//uses means 

//Authentication Routes
//Route::get('auth/login', 'Auth\LoginController@getLogin');
//Route::post('auth/login', 'Auth\LoginController@postLogin');
//Route::get('auth/logout', 'Auth\LoginController@getLogout');

// Registration Routes
Auth::routes();
//Route::get('auth/register', 'Auth\RegisterController@getRegister');
//Route::post('auth/register', ['uses' => 'Auth\RegisterController@postRegister', 'as' => 'auth.register']);


Route::get('blog/{slug}',['as' => 'blog.single' , 'uses' => 'BlogController@getSingle'])
->where('slug','[\w\d\-\_]+');
//w means any letter
//d means any number

Route::get('blog', ['uses' => 'BlogController@getIndex' , 'as' => 'blog.index']);

Route::get('/', 'PagesController@getIndex');
Route::get('about','PagesController@getAbout');
Route::get('contact', 'PagesController@getContact');

Route::post('contact', 'PagesController@postContact');

// Posts CRUD
Route::resource('posts','PostController');

//Password Reset Routes
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm');
//Route::post('password/email', 'Auth\ResetPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


// Categories CRUD(Resource) removing create function
Route::resource('categories','CategoryController',['except'=> ['create']]);

//Tags CRUD

Route::resource('tags','TagController',['except' => 'create']);

//Commets CRUD
Route::post('comments/{post_id}',['uses' => 'CommentsController@store','as' => 'comments.store']);
Route::get('comments/{id}/edit',['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
Route::put('comments/{id}',['uses' => 'CommentsController@update', 'as' => 'comments.update']);
Route::delete('comments/{id}',['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
Route::get('comments/{id}/delete',['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);


    
