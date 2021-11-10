<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

/** Users Routes */
Route::get('userlist','API\UserController@index');
Route::post('userstore','API\UserController@store');
Route::get('usershow/{id}','API\UserController@show');
Route::get('userupdate/{id}','API\UserController@update');
Route::get('userdelete/{id}','API\UserController@softDeletes');
/** Clients Routes */
Route::get('clientlist','API\ClientController@index');
Route::post('clientstore','API\ClientController@store');
Route::get('clientshow/{id}','API\ClientController@show');
Route::get('clientupdate/{id}','API\ClientController@update');
Route::get('clientdelete/{id}','API\ClientController@softDeletes');
/** ContactClients Routes */
Route::get('contactclientlist','API\ContactClientController@index');
Route::post('contactclientstore','API\ContactClientController@store');
Route::get('contactclientshow/{id}','API\ContactClientController@show');
Route::get('contactclientupdate/{id}','API\ContactClientController@update');
Route::get('contactclientdelete/{id}','API\ContactClientController@softDeletes');
/** Jobs Routes */
Route::get('joblist','API\JobController@index');
Route::post('jobstore','API\JobController@store');
Route::get('jobshow/{id}','API\JobController@show');
Route::get('jobupdate/{id}','API\JobController@update');
Route::get('jobdelete/{id}','API\JobController@softDeletes');
/** Candidates Routes */
Route::get('candidatelist','API\candidateController@index');
Route::post('candidatestore','API\candidateController@store');
Route::get('candidateshow/{id}','API\candidateController@show');
Route::get('candidateupdate/{id}','API\candidateController@update');
Route::get('candidatedelete/{id}','API\candidateController@softDeletes');
