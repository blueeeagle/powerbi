<?php

Route::view('forgot_password', 'auth.reset_password')->name('password.reset');
Route::view('password/success', 'auth.passwords.success')->name('password.success');
//Route::get('password/success', 'UsersController@passwordSuccess')->name('password.success'); 

Route::redirect('/', '/login');

//Route::redirect('/home', '/services/admin');
Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');
    Route::get('users/{id}/bookedcourse', 'UsersController@bookedcourse')->name('users.bookedcourse');
    Route::get('users/{id}/payment', 'UsersController@payment')->name('users.payment');
    Route::get('users/{id}/passwordreset', 'UsersController@passwordreset')->name('users.passwordreset'); 
    Route::get('users/{id}/athletelist', 'UsersController@athletelist')->name('users.athletelist');
    Route::get('users/{id}/courselist', 'UsersController@courselist')->name('users.courselist');

    
    
    Route::post('users/passwordUpdate/{id}', 'UsersController@passwordUpdate')->name('users.passwordUpdate');


    Route::resource('categories', 'CategoryController');

    Route::resource('courses', 'CoursesController');
    Route::resource('payments', 'PaymentsController')->only(['index']);

    Route::resource('dashboard', 'DashboardController')->only(['index']);    

});