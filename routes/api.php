<?php

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

// Public
Route::get('register-information', 'api\PassportController@registerInformation');
Route::post('login', 'api\PassportController@login');
Route::post('recover-password', 'api\UserController@recoverPassword');
Route::post('register', 'api\PassportController@register');
Route::put('activate-account/{userId}', 'api\PassportController@activateAccount');
Route::put('update-password/{userId}', 'api\UserController@updatePassword');


// Private
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('blogs', 'api\BlogsController@index');
    Route::get('blog-entry', 'api\BlogsController@getEntry');
    Route::get('blog-sections', 'api\BlogSectionsController@index');
    Route::get('contact-information', 'api\ContactController@index');
    Route::get('events', 'api\EventsController@index');
    Route::get('indicators', 'api\IndicatorsController@index');
    Route::get('news', 'api\NewsController@index');
    Route::get('news-alerts', 'api\NewsController@getDailyNewsAlerts');
    Route::get('news-digest', 'api\NewsDigestController@index');
    Route::get('news-entry', 'api\NewsEntryController@detail');
    Route::get('static-content', 'api\StaticContentController@detail');
    Route::get('update-profile-information', 'api\UserController@updateProfileInformation');
    
    Route::post('contact', 'api\ContactController@contact');
    Route::post('logout', 'api\PassportController@logout');
    
    Route::put('change-password/{userId}', 'api\UserController@changePassword');
    Route::put('user/{userId}', 'api\UserController@updateProfile');
    
});
