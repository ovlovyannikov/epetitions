<?php

Route::get('/', [
	'uses'=> '\Mygov\Http\Controllers\HomeController@index',
	'as' => 'home',
]);

Route::get('/alert', function () {
	return redirect()->route('home')->with('info', 'Ви зареєструвалися!');
});

Route::get('/signup', [
	'uses'=> '\Mygov\Http\Controllers\AuthController@getSignup',
	'as' => 'auth.signup',
	'middleware' => ['guest'],
]);

Route::post('/signup', [
	'uses'=> '\Mygov\Http\Controllers\AuthController@postSignup',
	'middleware' => ['guest'],
]);

Route::get('/signin', [
	'uses'=> '\Mygov\Http\Controllers\AuthController@getSignin',
	'as' => 'auth.signin',
	'middleware' => ['guest'],
]);

Route::post('/signin', [
	'uses'=> '\Mygov\Http\Controllers\AuthController@postSignin',
	'middleware' => ['guest'],
]);

Route::get('/signout', [
	'uses'=> '\Mygov\Http\Controllers\AuthController@getSignout',
	'as' => 'auth.signout',
]);

Route::get('/search', [
	'uses'=> '\Mygov\Http\Controllers\SearchController@getResults',
	'as' => 'search.results',
]);

Route::get('/user/{username}', [
	'uses'=> '\Mygov\Http\Controllers\ProfileController@getProfile',
	'as' => 'profile.index',
]);

Route::get('/profile/edit', [
	'uses'=> '\Mygov\Http\Controllers\ProfileController@getEdit',
	'as' => 'profile.edit',
	'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
	'uses'=> '\Mygov\Http\Controllers\ProfileController@postEdit',
	'middleware' => ['auth'],
]);

/*Петиції*/

Route::post('/petition/add', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@postPetition',
	'middleware' => ['auth'],
]);

Route::get('/petition/add', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getPetition',
	'as' => 'petition.add',
	'middleware' => ['auth'],
]);

Route::get('/petition', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getPetition',
	'as' => 'petition.index',
	'middleware' => ['guest'],
]);

Route::get('/petition/item/{petitionId}', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getItem',
	'as' => 'petition.item'
]);

Route::get('/petition/sign/{petitionId}', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getSign',
	'as' => 'petition.sign',
	'middleware' => ['auth'],
]);

Route::get('/petition/{statusId}', [
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getPetsByStatus',
	'as' => 'petition.index',
]);

Route::get('/petition/rules',[
	'uses'=> '\Mygov\Http\Controllers\PetitionController@getPetitionRules',
	'as' => 'petition.rules',
]);
