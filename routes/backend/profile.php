<?php
Route::group(['namespace' => 'Profile'], function() {

    Route::view('/profile', 'backend.profile.profile')->name('profile');
    Route::view('/profile/password', 'backend.profile.password')->name('profile.password');

    // api
    Route::group(['prefix' => 'api/profile'], function() {
        Route::get('/getAuthUser', 'ProfileController@getAuthUser')->name('getAuthUser');
        Route::put('/updateAuthUser', 'ProfileController@updateAuthUser');
        Route::put('/updatePasswordAuthUser', 'ProfileController@updatePasswordAuthUser');
        Route::post('/uploadAvatarAuthUser', 'ProfileController@uploadAvatarAuthUser');
        Route::post('/removeAvatarAuthUser', 'ProfileController@removeAvatarAuthUser');
    });
});
