<?php
Auth::routes();
Route::group(["namespace" => "Admin", 'middleware' => 'admin', 'auth'], function () {

    Route::get('', 'HomeController@index');

    Route::group(["namespace" => "ACL", 'middleware' => 'permission:acl-list'], function () {
        Route::prefix('/user')->middleware('permission:user-list')->group(function () {
            Route::get('/index', 'UserController@index')->middleware('permission:user-index');
            Route::get('/create', 'UserController@create')->middleware('permission:user-create');
            Route::Post('/store', 'UserController@store')->middleware('permission:user-create');
            Route::get('/edit/{id}', 'UserController@edit')->middleware('permission:user-edit');
            Route::patch('/update/{id}', 'UserController@update')->middleware('permission:user-edit');
            Route::get('/password/{id}', 'UserController@password')->middleware('permission:user-password');
            Route::patch('/change_password/{id}', 'UserController@change_password')->middleware('permission:user-password');
            Route::get('/change_status/{id}', 'UserController@change_status')->middleware('permission:user-status');
            Route::get('/change_many_status', 'UserController@change_many_status')->middleware('permission:user-many-status');
            Route::get('/upgrad/{id}', 'UserController@upgrad_user')->middleware('permission:user-upgrad');
        });
        Route::prefix('/friend')->middleware('permission:friend-list')->group(function () {
            Route::get('/request', 'FriendController@request_index')->middleware('permission:friend-request');
            Route::get('/', 'FriendController@friend_index')->middleware('permission:friend-friend');
        });
        Route::prefix('/takeed')->middleware('permission:takeed-list')->group(function () {
            Route::prefix('/import')->middleware('permission:import-list')->group(function () {
                Route::get('/form', 'TakeedController@form')->middleware('permission:takeed-form-import');
                Route::post('', 'TakeedController@import')->middleware('permission:takeed-import');
            });
            Route::get('/index', 'TakeedController@index')->middleware('permission:takeed-index');
        });
        Route::prefix('/forgot_password')->middleware('permission:forgot-password-list')->group(function () {
            Route::get('/index/{id}', 'ForgotPasswordController@index')->middleware('permission:forgot-password');
        });

        Route::prefix('/role')->middleware('permission:role-list')->group(function () {
            Route::get('/index', 'RoleController@index')->middleware('permission:role-index');
            Route::get('/create', 'RoleController@create')->middleware('permission:role-create');
            Route::Post('/store', 'RoleController@store')->middleware('permission:role-create');
            Route::get('/edit/{id}', 'RoleController@edit')->middleware('permission:role-edit');
            Route::patch('/update/{id}', 'RoleController@update')->middleware('permission:role-edit');
        });

        Route::prefix('/permission')->middleware('permission:permission-list')->group(function () {
            Route::get('/index', 'PermissionController@index')->middleware('permission:permission-index');
            Route::get('/create', 'PermissionController@create')->middleware('permission:permission-create');
            Route::Post('/store', 'PermissionController@store')->middleware('permission:permission-create');
            Route::get('/edit/{id}', 'PermissionController@edit')->middleware('permission:permission-edit');
            Route::patch('/update/{id}', 'PermissionController@update')->middleware('permission:permission-edit');
        });

        Route::prefix('/log')->middleware('permission:log-list')->group(function () {
            Route::get('/index', 'LogController@index')->middleware('permission:log-index');
            Route::get('/user/index/{id}', 'LogController@user_index')->middleware('permission:log-user-index');
            Route::Post('/store', 'LogController@store')->middleware('permission:log-create');
        });
    });

    Route::group(["namespace" => "Core_Data", 'middleware' => 'permission:core-data-list'], function () {
        Route::prefix('/circle')->middleware('permission:circle-list')->group(function () {
            Route::get('/index', 'CircleController@index')->middleware('permission:circle-index');
            Route::get('/create', 'CircleController@create')->middleware('permission:circle-create');
            Route::Post('/store', 'CircleController@store')->middleware('permission:circle-create');
            Route::get('/edit/{id}', 'CircleController@edit')->middleware('permission:circle-edit');
            Route::patch('/update/{id}', 'CircleController@update')->middleware('permission:circle-edit');
            Route::get('/change_status/{id}', 'CircleController@change_status')->middleware('permission:circle-status');
            Route::get('/change_many_status', 'CircleController@change_many_status')->middleware('permission:circle-many-status');
        });

        Route::prefix('/area')->middleware('permission:area-list')->group(function () {
            Route::get('/index', 'AreaController@index')->middleware('permission:area-index');
            Route::get('/create', 'AreaController@create')->middleware('permission:area-create');
            Route::Post('/store', 'AreaController@store')->middleware('permission:area-create');
            Route::get('/edit/{id}', 'AreaController@edit')->middleware('permission:area-edit');
            Route::patch('/update/{id}', 'AreaController@update')->middleware('permission:area-edit');
            Route::get('/change_status/{id}', 'AreaController@change_status')->middleware('permission:area-status');
            Route::get('/change_many_status', 'AreaController@change_many_status')->middleware('permission:area-many-status');
            Route::get('/Get_List_Areas_Json', 'AreaController@Get_List_Areas_Json');
        });

    });

    Route::group(["namespace" => "Setting", 'middleware' => 'permission:setting-list'], function () {
        Route::prefix('/setting')->middleware('permission:setting-list')->group(function () {
            Route::get('/index', 'SettingController@index')->middleware('permission:setting-index');
            Route::get('/create', 'SettingController@create')->middleware('permission:setting-create');
            Route::Post('/store', 'SettingController@store')->middleware('permission:setting-create');
            Route::get('/edit/{id}', 'SettingController@edit')->middleware('permission:setting-edit');
            Route::patch('/update/{id}', 'SettingController@update')->middleware('permission:setting-edit');
        });

        Route::prefix('/about_us')->middleware('permission:about-us-list')->group(function () {
            Route::get('/index', 'AboutUsController@index')->middleware('permission:about-us-index');
            Route::get('/create', 'AboutUsController@create')->middleware('permission:about-us-create');
            Route::Post('/store', 'AboutUsController@store')->middleware('permission:about-us-create');
            Route::get('/edit/{id}', 'AboutUsController@edit')->middleware('permission:about-us-edit');
            Route::patch('/update/{id}', 'AboutUsController@update')->middleware('permission:about-us-edit');
        });

        Route::prefix('/contact_us')->middleware('permission:contact-us-list')->group(function () {
            Route::get('/index', 'ContactUsController@index')->middleware('permission:contact-us-index');
            Route::get('/create', 'ContactUsController@create')->middleware('permission:contact-us-create');
            Route::Post('/store', 'ContactUsController@store')->middleware('permission:contact-us-create');
            Route::get('/edit/{id}', 'ContactUsController@edit')->middleware('permission:contact-us-edit');
            Route::patch('/update/{id}', 'ContactUsController@update')->middleware('permission:contact-us-edit');
        });

        Route::prefix('/call_us')->middleware('permission:call-us-list')->group(function () {
            Route::get('/read', 'CallUsController@read')->middleware('permission:call-us-read');
            Route::get('/unread', 'CallUsController@unread')->middleware('permission:call-us-unread');
            Route::get('/change_status/{id}', 'CallUsController@change_status')->middleware('permission:call-us-change-status');
            Route::get('/delete/{id}', 'CallUsController@delete')->middleware('permission:call-us-delete');
        });

        Route::prefix('/privacy')->middleware('permission:privacy-list')->group(function () {
            Route::get('/index', 'PrivacyController@index')->middleware('permission:privacy-index');
            Route::get('/create', 'PrivacyController@create')->middleware('permission:privacy-create');
            Route::Post('/store', 'PrivacyController@store')->middleware('permission:privacy-create');
            Route::get('/edit/{id}', 'PrivacyController@edit')->middleware('permission:privacy-edit');
            Route::patch('/update/{id}', 'PrivacyController@update')->middleware('permission:privacy-edit');
        });
    });

    Route::group(["namespace" => "Social_Media", 'middleware' => 'permission:social-media-list'], function () {
        Route::prefix('/post')->middleware('permission:post-list')->group(function () {
            Route::get('/index', 'PostController@index')->middleware('permission:post-index');
            Route::get('/change_status/{id}', 'PostController@change_status')->middleware('permission:post-status');
            Route::get('/change_many_status', 'PostController@change_many_status')->middleware('permission:post-many-status');
        });

        Route::prefix('/commit')->middleware('permission:commit-list')->group(function () {
            Route::get('/index', 'CommitController@index')->middleware('permission:commit-index');
            Route::get('post/index/{id}', 'CommitController@Post_index')->middleware('permission:commit-post-index');
            Route::get('like/index/{id}', 'CommitController@Like_index')->middleware('permission:commit-like-index');
            Route::get('/change_status/{id}', 'CommitController@change_status')->middleware('permission:commit-status');
            Route::get('/change_many_status', 'CommitController@change_many_status')->middleware('permission:commit-many-status');
        });

        Route::prefix('/like')->middleware('permission:like-list')->group(function () {
            Route::get('/index', 'LikeController@index')->middleware('permission:like-index');
            Route::get('/index/{id}/{category}', 'LikeController@Like_index')->middleware('permission:like-index-category');
        });
    });
    Route::group(["namespace" => "Election", 'middleware' => 'permission:election-list'], function () {
        Route::prefix('/vote')->middleware('permission:vote-list')->group(function () {
            Route::get('/index', 'VoteController@index')->middleware('permission:vote-index');
            Route::get('/create', 'VoteController@create')->middleware('permission:vote-create');
            Route::Post('/store', 'VoteController@store')->middleware('permission:vote-create');
            Route::get('/edit/{id}', 'VoteController@edit')->middleware('permission:vote-edit');
            Route::patch('/update/{id}', 'VoteController@update')->middleware('permission:vote-edit');
            Route::get('/change_status/{id}', 'VoteController@change_status')->middleware('permission:vote-status');
            Route::get('/change_many_status', 'VoteController@change_many_status')->middleware('permission:vote-many-status');
        });
    });
});
