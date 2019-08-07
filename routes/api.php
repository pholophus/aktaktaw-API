<?php

use Illuminate\Http\Request;



$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    //route that doesnt needed token
    $api->group(['namespace' => 'App\Http\Controllers\V1'], function ($api) {
        $api->post('auth/login', 'Auth\AuthController@login');
    });



    //guarded route
    $api->group(['middleware' => ['jwt.verify'], 'namespace' => 'App\Http\Controllers\V1'], function ($api) {
        //non namespace
        $api->post('auth/logout', 'Auth\AuthController@logout');
        $api->post('auth/reset', 'Auth\AuthController@resetPassword');

        $api->group(['prefix' => 'notification', 'namespace' => 'Notification'], function ($api) {
            $api->post('/', 'NotificationController@notify');
        });

        //user management
        $api->group(['prefix' => 'users', 'namespace' => 'User'], function ($api) {
            $api->post('/search', 'UserController@search');

            $api->get('/', 'UserController@index');
            $api->get('/{id}', 'UserController@show');
            $api->post('/', 'UserController@store');
            $api->put('/{id}', 'UserController@update');
            $api->delete('/{id}', 'UserController@destroy');
        });

        $api->group(['prefix' => 'language', 'namespace' => 'LanguageUser'], function ($api) {
            $api->get('/', 'LanguageUserController@index');
            $api->get('/no-paginate', 'LanguageUserController@getWithoutPagination');
            $api->get('/{id}', 'LanguageUserController@show');
            $api->post('/', 'LanguageUserController@store');
            $api->put('/{id}', 'LanguageUserController@update');
            $api->delete('/{id}', 'LanguageUserController@destroy');
        $api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($api) {

            $api->get('/me', 'ProfileController@showProfile');
            $api->put('/update', 'ProfileController@updateProfile');
        });

        //Role/
        $api->group(['prefix' => 'role', 'namespace' => 'Role'], function ($api) {
            $api->get('/', 'RoleController@index');
            $api->get('/{id}', 'RoleController@show');
            $api->post('/', 'RoleController@store');
            $api->put('/{id}', 'RoleController@update');
            $api->delete('/{id}', 'RoleController@destroy');
        });

        //Wallet
        $api->group(['prefix' => 'Wallet', 'namespace' => 'Wallet'], function ($api) {
            $api->post('/', 'WalletController@store');
            $api->get('/', 'WalletController@show');
            $api->put('/{id}', 'WalletController@update');
         //Expertise/
         $api->group(['prefix' => 'expertises', 'namespace' => 'Expertise'], function ($api) {
            $api->get('/', 'ExpertiseController@index');
            $api->get('/{id}', 'ExpertiseController@show');
            $api->post('/', 'ExpertiseController@store');
            $api->put('/{id}', 'ExpertiseController@update');
            $api->delete('/{id}', 'ExpertiseController@destroy');
        });
         //Booking/
         $api->group(['prefix' => 'bookings', 'namespace' => 'Booking'], function ($api) {
            $api->get('/', 'BookingController@index');
            $api->get('/{id}', 'BookingController@show');
            $api->post('/', 'BookingController@store');
            $api->put('/{id}', 'BookingController@update');
            $api->delete('/{id}', 'BookingController@destroy');
        });
    });
});
