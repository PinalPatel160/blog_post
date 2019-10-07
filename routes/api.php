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

Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');

Route::get('email/verify/{id}', 'VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verificationapi.resend');


Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'LoginController@logout');
    Route::get('user-profile','UserController@userProfile');
    Route::put('user-profile','UserController@update');
});

Route::resource('blogPost', 'BlogPostController');
Route::resource('category', 'CategoryController');
