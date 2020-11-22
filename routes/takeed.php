<?php
//$htt = $_SERVER['HTTP_ORIGIN'];
/*$allowedOrigins = ['http://localhost:3000','http://pano.deal360.ae/'];
header('Access-Control-Allow-Origin: *,'.$allowedOrigins);*/
header('Access-Control-Allow-Origin: *');
header('Accept: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');



Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Takeed'], function () {
        Route::group(['namespace' => 'ACL'], function () {
            Route::group(['prefix' => 'auth'], function () {
                Route::post('login', 'AuthController@login');
                Route::post('logout', 'AuthController@logout');
                Route::post('refresh', 'AuthController@refresh');
                Route::post('me', 'AuthController@me');
            });
        });
            Route::group(['namespace' => 'Election'], function () {
            Route::group(['prefix' => 'takeed'], function () {
                Route::get('filter/index', 'TakeedController@index');
                Route::get('filter', 'TakeedController@filter');

            });
        });
    });
});