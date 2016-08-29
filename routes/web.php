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
Route::get('blog/{slug}',['as' => 'blog.single' , 'uses' => 'BlogController@getSingle'])
->where('slug','[\w\d\-\_]+');
//w means any letter
//d means any number

Route::get('/', 'PagesController@getIndex');
Route::get('about','PagesController@getAbout');
Route::get('contact', 'PagesController@getContact');

Route::resource('posts','PostController');
    
