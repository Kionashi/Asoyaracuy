<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Admin
if (Request::is('admin*')) {
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'admin.auth'],
        'namespace' => 'Admin'
    ],
    function() {
        // Admin
        Route::get('/', 'Home@index')->name('admin');
        
        // Admin user
        Route::get('management/admin-users', 'Management\AdminUsers@index')->name('management/admin-users');
        Route::get('management/admin-users/add', 'Management\AdminUsers@add')->name('management/admin-users/add');
        Route::get('management/admin-users/change-password/{id}', 'Management\AdminUsers@changePassword')->name('management/admin-users/change-password');
        Route::get('management/admin-users/delete/{id}', 'Management\AdminUsers@delete')->name('management/admin-users/delete');
        Route::get('management/admin-users/detail/{id}', 'Management\AdminUsers@detail')->name('management/admin-users/detail');
        Route::get('management/admin-users/edit/{id}', 'Management\AdminUsers@edit')->name('management/admin-users/edit');
        Route::post('management/admin-users/add', 'Management\AdminUsers@store')->name('management/admin-users/add');
        Route::post('management/admin-users/edit/{id}', 'Management\AdminUsers@update')->name('management/admin-users/edit');
        Route::post('management/admin-users/change-password/{id}', 'Management\AdminUsers@updatePassword')->name('management/admin-users/change-password');
        
        // Audits
        Route::get('audits', 'Management\AuditsController@index')->name('audits');
        Route::get('audits/detail/{id}', 'Management\AuditsController@detail')->name('audits/detail');
        
        // Config item
        Route::get('management/config-items', 'Management\ConfigItems@index')->name('management/config-items');
        Route::get('management/config-items/detail/{id}', 'Management\ConfigItems@detail')->name('management/config-items/detail');
        Route::get('management/config-items/edit/{id}', 'Management\ConfigItems@edit')->name('management/config-items/edit');
        Route::post('management/config-items/edit/{id}', 'Management\ConfigItems@update')->name('management/config-items/edit');
        
        // Contact
        Route::get('management/contacts', 'Management\Contacts@index')->name('management/contacts');
        Route::get('management/contacts/detail/{id}', 'Management\Contacts@detail')->name('management/contacts/detail');
        
        // Contact reason
        Route::get('management/contact-reasons', 'Management\ContactReasons@index')->name('management/contact-reasons');
        Route::get('management/contact-reasons/add', 'Management\ContactReasons@add')->name('management/contact-reasons/add');
        Route::get('management/contact-reasons/delete/{id}', 'Management\ContactReasons@delete')->name('management/contact-reasons/delete');
        Route::get('management/contact-reasons/detail/{id}', 'Management\ContactReasons@detail')->name('management/contact-reasons/detail');
        Route::get('management/contact-reasons/edit/{id}', 'Management\ContactReasons@edit')->name('management/contact-reasons/edit');
        Route::post('management/contact-reasons/add', 'Management\ContactReasons@store')->name('management/contact-reasons/add');
        Route::post('management/contact-reasons/edit/{id}', 'Management\ContactReasons@update')->name('management/contact-reasons/edit');
        
        // Dashboard
        Route::get('dashboard', 'Dashboard@index')->name('dashboard');
        
        // Logout
        Route::get('logout', 'Logout@index')->name('logout');
        
        // Password recovery
        Route::get('password-recovery', 'PasswordRecovery@index')->name('password-recovery');
        Route::get('password-recovery/change-password/{code}', 'PasswordRecovery@changePassword')->name('password-recovery/change-password');
        Route::get('password-recovery/message-password-changed', 'PasswordRecovery@messagePasswordChanged')->name('password-recovery/message-password-changed');
        Route::post('password-recovery', 'PasswordRecovery@passwordRecovery')->name('password-recovery');
        Route::post('password-recovery/change-password/{code}', 'PasswordRecovery@storeChangePassword')->name('password-recovery/change-password');
        
        // Payment
        Route::get('management/payments', 'Management\PaymentsController@index')->name('management/payments');
        Route::get('management/payments/detail/{id}', 'Management\PaymentsController@detail')->name('management/payments/detail');
        Route::get('management/payments/approve/{id}', 'Management\PaymentsController@approve')->name('management/payments/approve');
        Route::get('management/payments/reject/{id}', 'Management\PaymentsController@reject')->name('management/payments/reject');
        
        // Poll
        Route::get('management/polls', 'Management\Polls@index')->name('management/polls');
        Route::get('management/polls/add', 'Management\Polls@add')->name('management/polls/add');
        Route::get('management/polls/delete/{id}', 'Management\Polls@delete')->name('management/polls/delete');
        Route::get('management/polls/detail/{id}', 'Management\Polls@detail')->name('management/polls/detail');
        Route::get('management/polls/result/{id}', 'Management\Polls@result')->name('management/polls/result');
        Route::get('management/polls/edit/{id}', 'Management\Polls@edit')->name('management/polls/edit');
        Route::post('management/polls/add', 'Management\Polls@store')->name('management/polls/add');
        Route::post('management/polls/edit/{id}', 'Management\Polls@update')->name('management/polls/edit');
        
        // Sign In
        Route::get('sign-in', 'SignIn@index')->name('sign-in');
        Route::post('sign-in', 'SignIn@authenticate')->name('sign-in/authenticate');
        
        // Special fee
        Route::get('management/special-fees', 'Management\SpecialFeesController@index')->name('management/special-fees');
        Route::get('management/special-fees/add', 'Management\SpecialFeesController@add')->name('management/special-fees/add');
        Route::get('management/special-fees/delete/{id}', 'Management\SpecialFeesController@delete')->name('management/special-fees/delete');
        Route::get('management/special-fees/detail/{id}', 'Management\SpecialFeesController@detail')->name('management/special-fees/detail');
        Route::get('management/special-fees/edit/{id}', 'Management\SpecialFeesController@edit')->name('management/special-fees/edit');
        Route::post('management/special-fees/add', 'Management\SpecialFeesController@store')->name('management/special-fees/add');
        Route::post('management/special-fees/edit/{id}', 'Management\SpecialFeesController@update')->name('management/special-fees/edit');
        
        // Static content
        Route::get('management/static-contents', 'Management\StaticContents@index')->name('management/static-contents');
        Route::get('management/static-contents/add', 'Management\StaticContents@add')->name('management/static-contents/add');
        Route::get('management/static-contents/delete/{id}', 'Management\StaticContents@delete')->name('management/static-contents/delete');
        Route::get('management/static-contents/detail/{id}', 'Management\StaticContents@detail')->name('management/static-contents/detail');
        Route::get('management/static-contents/edit/{id}', 'Management\StaticContents@edit')->name('management/static-contents/edit');
        Route::post('management/static-contents/add', 'Management\StaticContents@store')->name('management/static-contents/add');
        Route::post('management/static-contents/edit/{id}', 'Management\StaticContents@update')->name('management/static-contents/edit');
        
        // User
        Route::get('management/users', 'Management\UsersController@index')->name('management/users');
        Route::get('management/users/add', 'Management\UsersController@add')->name('management/users/add');
        Route::get('management/users/change-password/{id}', 'Management\UsersController@changePassword')->name('management/users/change-password');
        Route::get('management/users/delete/{id}', 'Management\UsersController@delete')->name('management/users/delete');
        Route::get('management/users/detail/{id}', 'Management\UsersController@detail')->name('management/users/detail');
        Route::get('management/users/edit/{id}', 'Management\UsersController@edit')->name('management/users/edit');
        Route::post('management/users/add', 'Management\UsersController@store')->name('management/users/add');
        Route::post('management/users/edit/{id}', 'Management\UsersController@update')->name('management/users/edit');
        Route::post('management/users/change-password/{id}', 'Management\UsersController@updatePassword')->name('management/users/change-password');
        
    });
}

// Frontend
else {
    Route::group([
        'middleware' => ['web'],
        'namespace' => 'Frontend'
    ],
    function() {
        // Root redirects to home
        Route::get('/', function () {
            dump("FRONTEND"); die;
        })->name('root');
    });
}