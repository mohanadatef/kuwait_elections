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
    Route::group(['namespace' => 'ACL'], function () {
        Route::post('sign_up', 'UserController@store');
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'AuthController@login');
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('show', 'UserController@show');
            Route::get('search', 'UserController@search_user');
            Route::post('update', 'UserController@update');
            Route::post('change_password', 'UserController@change_password');
        });
        Route::group(['prefix' => 'image/profile'], function () {
            Route::get('index', 'ImageUserController@index');
            Route::post('store', 'ImageUserController@store');
            Route::post('update', 'ImageUserController@update');
            Route::get('delete', 'ImageUserController@delete');
        });
        Route::group(['prefix' => 'friend'], function () {
            Route::get('all_friend', 'FriendController@all_friend');
            Route::get('all_request_friend', 'FriendController@all_request_friend');
            Route::get('check_friend', 'FriendController@check_friend');
            Route::post('send_friend', 'FriendController@send_friend');
            Route::post('accept_friend', 'FriendController@accept_friend');
            Route::get('delete_friend', 'FriendController@delete_friend');
        });
        Route::group(['prefix' => 'log'], function () {
            Route::get('index', 'LogController@index');
        });

        Route::group(['prefix' => 'forgot_password'], function () {
            Route::post('check', 'ForgotPasswordController@check');
            Route::post('validate_code', 'ForgotPasswordController@validate_code');
            Route::post('change_password', 'ForgotPasswordController@change_password');
        });
    });
    Route::group(['namespace' => 'Social_Media'], function () {
        Route::group(['prefix' => 'post'], function () {
            Route::post('store', 'PostController@store');
            Route::get('all_post_user', 'PostController@show_all_post_user');
            Route::get('show', 'PostController@show');
            Route::post('update', 'PostController@update');
            Route::get('delete', 'PostController@delete');
            Route::get('like', 'PostController@like');
            Route::get('share', 'PostController@share');
        });
        Route::group(['prefix' => 'commit'], function () {
            Route::post('store', 'CommitController@store');
            Route::post('update', 'CommitController@update');
            Route::get('delete', 'CommitController@delete');
            Route::get('like', 'CommitController@like');
        });
        Route::group(['prefix' => 'chat'], function () {
            Route::get('index', 'MessageController@index');
            Route::post('store', 'MessageController@store');
            Route::get('delete', 'MessageController@delete');
        });
        Route::group(['namespace' => 'Group'], function () {
            Route::group(['prefix' => 'group'], function () {
                Route::get('show_all_group', 'GroupController@show_all_group');
                Route::group(['prefix' => 'post'], function () {
                    Route::post('store', 'GroupPostController@store');
                    Route::get('all_post_group', 'GroupPostController@show_all_post_group');
                });
            });
            Route::group(['prefix' => 'group_member'], function () {
                Route::post('join', 'GroupMemberController@join');
                Route::get('leave', 'GroupMemberController@leave');
            });
        });
    });
    Route::group(['namespace' => 'Election'], function () {
        Route::group(['prefix' => 'nominee'], function () {
            Route::get('show', 'NomineeController@show');
            Route::get('show_list', 'NomineeController@show_list');
            Route::post('election', 'NomineeController@election');
        });
        Route::group(['prefix' => 'vote'], function () {
            Route::get('show', 'VoteController@show');
            Route::get('vote', 'VoteController@vote');
        });
    });
    Route::group(['namespace' => 'Setting'], function () {
        Route::get('about_us', 'AboutUsController@index');
        Route::get('privacy', 'PrivacyController@index');
        Route::get('contact_us', 'ContactUsController@index');
        Route::get('setting_details', 'SettingController@index');
        Route::post('call_us', 'CallUsController@store');
        Route::group(['prefix' => 'notification'], function () {
            Route::get('index', 'NotificationController@index');
        });
    });
    Route::group(['namespace' => 'Core_Data'], function () {
        Route::get('Circle_List', 'CircleController@index');
        Route::get('Area_List', 'AreaController@index');
    });
    Route::get('/', 'HomeController@index');
});