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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['middleware' => ['auth']], function(){
  Route::get('/', 'EndUserController@index');
  Route::get('/contacts/{contact}/detail', 'EndUserController@contactDetail');

  Route::get('/admin', 'AdminController@index'); //->middleware('isAdmin');

  $this->post('logout', 'Auth\LoginController@logout');

});

Auth::routes();


//Route::group(['middleware' => ['guest']], function(){
  // Registration Routes...
//  $this->get('register', 'Auth\RegisterController@showRegistrationForm');
//  $this->post('register', 'Auth\RegisterController@register');
//
//  // Authentication Routes...
//  $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//  $this->post('login', 'Auth\LoginController@login');

  // Password Reset Routes...
//  $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//  $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//  $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//  $this->post('password/reset', 'Auth\ResetPasswordController@reset');

//});


