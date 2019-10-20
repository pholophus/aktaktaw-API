
<?php

use Illuminate\Http\Request;



$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    //route that doesnt needed token
    $api->group(['namespace' => 'App\Http\Controllers\V1'], function ($api) {
        $api->post('auth/login', 'Auth\AuthController@login');
        $api->post('users', 'User\UserController@store');
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
            $api->get('/', 'UserController@index');
            $api->post('/', 'UserController@store');
            $api->post('/search', 'UserController@search');
            //$api->post('/', 'UserController@search');
            $api->get('/{id}', 'UserController@show');
            $api->put('/{id}', 'UserController@update');
            $api->delete('/{id}', 'UserController@destroy');
        });

        $api->group(['prefix' => 'language', 'namespace' => 'Language'], function ($api) {
            $api->get('/', 'LanguageController@index');
            //$api->get('/no-paginate', 'LanguageUserController@getWithoutPagination');
            $api->get('/{id}', 'LanguageController@show');
            $api->post('/', 'LanguageController@store');
            $api->put('/{id}', 'LanguageController@update');
            $api->delete('/{id}', 'LanguageController@destroy');
        });

        $api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($api) {

            $api->get('/me', 'ProfileController@showProfile');
            $api->post('/update', 'ProfileController@updateProfile');
            $api->put('/password', 'ProfileController@updatePassword');
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
        $api->group(['prefix' => 'wallet', 'namespace' => 'Wallet'], function ($api) {
            $api->get('/', 'WalletController@index');
            //user wallet
            $api->get('/me', 'WalletController@showUserWallet');
            $api->put('/update', 'WalletController@updateUserWallet');

            $api->get('/{id}', 'WalletController@show');
            $api->put('/{id}', 'WalletController@update');

        });
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
            $api->post('/{id}/translator', 'BookingController@addTranslator');
            $api->post('/{id}/end', 'BookingController@endBooking');
            $api->delete('/{id}', 'BookingController@destroy');
        });

        //Fee/
        $api->group(['prefix' => 'fee', 'namespace' => 'Fee'], function ($api) {
            $api->get('/', 'FeeController@index');
            $api->get('/{id}', 'FeeController@show');
            $api->post('/', 'FeeController@store');
            $api->put('/{id}', 'FeeController@update');
            $api->delete('/{id}', 'FeeController@destroy');
        });

        

        //LOC/
        $api->group(['prefix' => 'investor', 'namespace' => 'Investor'], function ($api) {
            $api->get('/', 'InvestorController@index');
            $api->get('/{id}', 'InvestorController@show');
            $api->post('/', 'InvestorController@store');
            $api->put('/{id}', 'InvestorController@update');
            $api->delete('/{id}', 'InvestorController@destroy');
        });
    });
});
