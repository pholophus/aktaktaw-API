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

            //user profile
            $api->get('/profile/me', 'UserController@showProfile');
            $api->put('/profile/update', 'UserController@updateProfile');
        });




        //Role/
        $api->group(['prefix' => 'role', 'namespace' => 'Role'], function ($api) {
            $api->get('/', 'RoleController@index');
            $api->get('/{id}', 'RoleController@show');
            $api->post('/', 'RoleController@store');
            $api->put('/{id}', 'RoleController@update');
            $api->delete('/{id}', 'RoleController@destroy');
        });
    });
});
