<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Sign up
Route::post('/register', 'RegisterController@register');

//Sign-in
Route::post('/login', 'LoginController@login');

//Email verification
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verificationapi.verify');

//Resend mail for email verification
Route::get('email/resend', 'VerificationController@resend')->name('verificationapi.resend');

Route::get('blogPost', 'BlogPostController@index');
Route::get('blogPost/{id}', 'BlogPostController@show');

Route::middleware('auth:api')->group(function () {

    //Logout
    Route::get('/logout', 'LoginController@logout');

    //Get and update user profile
    Route::get('user-profile','UserController@userProfile');
    Route::put('user-profile','UserController@update');

    //Blog searching
    Route::get('blogPost/search','BlogPostController@search');

    Route::resource('blogPost', 'BlogPostController');

    Route::resource('category', 'CategoryController');
});
