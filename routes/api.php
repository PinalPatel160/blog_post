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

Route::get('blog-post', 'BlogPostController@index');
Route::get('blog-post/{id}', 'BlogPostController@show');

//Blog searching
Route::get('blog/post/search', 'BlogPostController@search');

Route::middleware('auth:api')->group(function () {

    //Logout
    Route::get('/logout', 'LoginController@logout');

    //Get and update user profile
    Route::get('user-profile','UserController@userProfile');
    Route::put('user-profile','UserController@update');

    Route::resource('blog/post', 'BlogPostController');

    Route::resource('categories', 'CategoryController');

    Route::post('blog-published/{blogPost}', 'BlogPublishedController@store');
    Route::delete('blog-published/{blogPost}', 'BlogPublishedController@destroy');

});
