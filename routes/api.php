<?php

use Illuminate\Http\Request;
//use Illuminate\Routing\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})
//    ->middleware('auth:api');
//;

Route::group(['middleware' => ['auth:api']], function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/chat/{contactId}/messages', 'MessageController@getConversationWith');

    Route::post('/chat/{contactId}/messages', 'MessageController@sendTo');

    Route::get('/chat/contacts', 'EndUserController@getContacts');



    // ADMIN ENDPOINTS

    Route::get('/users', 'AdminController@getUsers');

    Route::get('/groups', 'AdminController@getGroups');

    Route::get('/users/{user}/groups', 'AdminController@getUserGroups');

    Route::post('/users/{user}/groups/{group}', 'AdminController@attachUserToGroup');
    Route::delete('/users/{user}/groups/{group}', 'AdminController@detachUserFromGroup');
});


