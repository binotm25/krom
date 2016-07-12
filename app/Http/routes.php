<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index');

Route::get('/home', 'HomeController@index');
Route::get('/policy', ['uses'=>'HomeController@privacy', 'as'=>'privacy_policy']);
Route::get('/terms', ['uses'=>'HomeController@terms', 'as'=>'privacy_terms']);

/**
 * Admin User Routes
 */
Route::group(['prefix' => 'admin/user'], function() {
    Route::get('/list', ['uses'=>'UserController@index','as'=>'admin_user_lists']);
    Route::get('/add', 'UserController@create');
    Route::POST('/save', 'UserController@store');
    Route::GET('/edit/{id}', 'UserController@edit');
    Route::POST('/update/{id}', 'UserController@update');
    Route::GET('/delete/{id}', 'UserController@destroy');
	Route::GET('/city/{userID}','UserController@fetchCityByUserID');
	Route::GET('/edit-password/{id}', 'UserController@editPassword');
	Route::POST('/edit-password/{id}', 'UserController@updatePassword');
});



/**
 * Interest Routes
 */
Route::group(['prefix' => 'admin/interest'], function() {
    Route::get('/list', ['uses'=>'InterestController@index','as'=>'admin_interest_list']);
    Route::get('/list/byuserid/{userID}', 'InterestController@fetchByUserID');
    Route::get('/add', 'InterestController@create');
    Route::POST('/save', 'InterestController@store');
    Route::GET('/edit/{id}', 'InterestController@edit');
    Route::POST('/update/{id}', 'InterestController@update');
    Route::GET('/delete/{id}', 'InterestController@destroy');
});


/**
 * Creation Routes
 */
Route::group(['prefix' => 'admin/creation'], function() {
    Route::get('/list', ['uses'=>'CreationController@index', 'as'=>'admin_list']);
    Route::get('/add', 'CreationController@create');
    Route::POST('/add', 'CreationController@store');
    Route::GET('/edit/{id}', 'CreationController@edit');
    Route::POST('/update/{id}', 'CreationController@update');
    Route::GET('/delete/{id}', 'CreationController@destroy');
});





//Route::auth();

//Route::get('/home', 'HomeController@index');

Route::get('/', 'HomeController@index');
Route::get('verify/email/{id}', ['uses'=>'ConsumerProfileController@verifyEmail', 'middleware'=>'guest']);
Route::post('/checkEmail', ['uses'=>'ConsumerProfileController@checkEmail', 'middleware'=>'guest']);
Route::get('password/reset/false/{id}', ['uses'=>'ConsumerProfileController@falsePasswordReset', 'middleware'=>'guest']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/interest', ['uses'=>'InterestsController@index']);
    Route::post('/interest/{id}', ['uses'=>'InterestsController@store']);

    Route::post('/search', ['uses'=>'FeedsController@search','as'=>'creation_search']);
    Route::get('/feeds', ['uses'=>'FeedsController@listFeeds','as'=>'user_feeds']);
    Route::get('/listings', ['uses'=>'FeedsController@myListingsGet','as'=>'myListing_feeds']);
    Route::get('creation/add', ['uses'=>'UserCreationsController@addCreationGet','as'=>'creation_add']);
    Route::post('creation/add', ['uses'=>'UserCreationsController@addCreationPost']);
    Route::get('creation/{id}/edit', ['uses'=>'UserCreationsController@editCreationGet','as'=>'creation_edit']);
    Route::patch('creation/{id}', ['uses'=>'UserCreationsController@editCreationPatch']);
    Route::delete('creation/{id}', ['uses'=>'UserCreationsController@editCreationDelete']);
    Route::get('creation/{id}', ['uses'=>'UserCreationsController@showCreation', 'as'=>'show_creation']);
    Route::get('collaborate/{id}', ['uses'=>'CollaborateController@collaborateGet', 'as'=>'collaborate']);
    Route::post('collaborate/{id}', ['uses'=>'CollaborateController@collaboratePost']);
    Route::get('collaboration', ['uses'=>'CollaborateController@lists', 'as'=>'my_collaborations']);

    Route::get('myInterest', ['uses'=>'ConsumerProfileController@myInterest', 'as'=>'my_interest']);
    Route::patch('myInterest', ['uses'=>'ConsumerProfileController@myInterestPatch']);
    Route::get('/profile', ['uses'=>'ConsumerProfileController@myProfile', 'as'=>'my_profile']);
    Route::get('/profile/edit', ['uses'=>'ConsumerProfileController@myProfileEdit', 'as'=>'edit_profile']);
    Route::patch('profile/edit', ['uses'=>'ConsumerProfileController@updateProfile']);
    Route::get('/{user}/profile', ['uses'=>'ConsumerProfileController@viewProfile','as'=>'profile_page']);
    Route::get('/editprofile/{id}', 'ConsumerProfileController@editprofile');
    Route::post('/profile', 'ConsumerProfileController@updatePics');
    Route::post('/profilePic', 'ConsumerProfileController@profilePic');
    Route::get('/profile/password', ['uses'=>'ConsumerProfileController@changePasswordGet','as'=>'change_password']);
    Route::post('/profile/password', ['uses'=>'ConsumerProfileController@changePasswordPost']);
    Route::post('/praise/{id}', ['uses'=>'ConsumerProfileController@praisePost', 'as'=>'praise']);
    Route::post('getPraise', ['uses'=>'ConsumerProfileController@getPraisePost', 'as'=>'get_praise']);
    Route::post('removeImageCreation/{id}', ['uses'=>'UserCreationsController@updateImages']);
    Route::post('addImageEdit/{id}', ['uses'=>'UserCreationsController@addImagesEdit']);
});


Route::get('/admin', ['uses' => 'AdminController@index']);
//Login Routes...
Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
Route::post('/admin/login','AdminAuth\AuthController@login');
Route::get('/admin/logout','AdminAuth\AuthController@logout');

// Registration Routes...
Route::get('admin/register', 'AdminAuth\AuthController@showRegistrationForm');
Route::post('admin/register', 'AdminAuth\AuthController@register');

Route::get('/admin', 'AdminController@index');
