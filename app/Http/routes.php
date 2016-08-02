<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/signin', ['as' => 'login', 'uses' => 'HomeController@signin']);
Route::get('/signup', ['as' => 'signup', 'uses' => 'HomeController@signup']);
Route::post('/signup/store', ['as' => 'signup_save', 'uses' => 'HomeController@signupSave']);
Route::post('/submitted', ['as' => 'cached', 'uses' => 'HomeController@tempSave']);
//Route::post('/submitted', ['as' => 'cached', 'uses' => 'HomeController@tempSave']);
Route::get('/success', ['as' => 'success', 'uses' => 'HomeController@SignUpSuccess']);

Route::post('/uniqueemail', ['as' => 'uniqueemail', 'uses' => 'HomeController@validateEmail']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
Route::post('auth', ['as' => 'auth', 'uses' => 'HomeController@auth']);

Route::get('stocks', 'DashboardController@getStocks');

//Route::group(['prefix' => 'portal','middleware' => ['web']], function () {
Route::group(['prefix' => 'portal','middleware' => ['auth']], function () {

    Route::auth();

//    Route::get('/', function ()    {
//        // Uses Auth Middleware
//        return view('Acme.dashboard');
//    });

    Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('/spreadsheet', ['as' => 'spreadsheet', 'uses' => 'DashboardController@spreadsheet']);

    Route::get('/algo_values', ['as' => 'algo_values', 'uses' => 'DashboardController@algo_values']);
    // Clients
    Route::group(['prefix' => 'clients', 'middleware' => 'web'],function(){
        Route::get('/', ['as' => 'clients', 'uses' => 'ClientController@index']);
        Route::get('/profile/{id}', ['as' => 'client_profile', 'uses' => 'ClientController@profile']);
        Route::get('/edit/{id}', ['as' => 'client_edit', 'uses' => 'ClientController@edit']);
        Route::get('/update/{id}', ['as' => 'client_update', 'uses' => 'ClientController@update']);
        Route::get('/delete/{id}', ['as' => 'client_destroy', 'uses' => 'ClientController@destroy']);
    });

    //
    Route::get('/logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);
    Route::group(['prefix' => 'permissions', 'middleware' => 'web'],function(){
        Route::get('/', ['as' =>'permission_list', 'uses' => 'PermissionController@index']);
        Route::get('/add', ['as' =>'permission_add', 'uses' => 'PermissionController@create']);
        Route::post('/store', ['as' =>'permission_store', 'uses' => 'PermissionController@store']);
        Route::get('/edit/{id}', ['as' =>'permission_edit', 'uses' => 'PermissionController@edit']);
        Route::post('/update/{id}', ['as' =>'permission_update', 'uses' => 'PermissionController@update']);
        Route::get('/delete/{id}',	['as' =>'permission_delete',    'uses' => 'PermissionController@destroy']);
    });


    Route::group(['prefix' => 'roles', 'middleware' => 'web'],function(){
        Route::get('/', ['as' =>'role_list', 'uses' => 'RoleController@index']);
        Route::get('/add', ['as' =>'role_add', 'uses' => 'RoleController@create']);
        Route::post('/store', ['as' =>'role_store', 'uses' => 'RoleController@store']);
        Route::get('/edit/{id}', ['as' =>'role_edit', 'uses' => 'RoleController@edit']);
        Route::post('/update/{id}', ['as' =>'role_update', 'uses' => 'RoleController@update']);
        Route::get('/delete/{id}',	['as' =>'role_delete',    'uses' => 'RoleController@destroy']);
    });


    Route::group(['prefix' => 'users', 'middleware' => 'web'],function(){
        Route::get('/',['as' => 'users', 'uses' => 'UserController@index']);
        Route::get('/create',['as' => 'user_create', 'uses' => 'UserController@create']);
        Route::get('/edit/{id}',['as' => 'user_edit', 'uses' => 'UserController@edit']);

        Route::post('/store',['as' => 'user_store', 'uses' => 'UserController@save']);
        Route::post('/update/{id}',['as' => 'user_update', 'uses' => 'UserController@save']);
        Route::get('/delete/{id}',['as' => 'user_destroy', 'uses' => 'UserController@destroy']);

        Route::get('/profile/{id?}',['as' => 'user_show', 'uses' => 'UserController@show']);

        Route::post('/assign_role/{id}',['as' => 'user_assign_role', 'uses' => 'UserController@assign_role']);

    });

    Route::group(['prefix' => 'flags', 'middleware'],function(){
        Route::get('/',['as' => 'flags', 'uses' => 'FlagController@index']);
        Route::get('/create',['as' => 'flags_create', 'uses' => 'FlagController@create']);
        Route::post('/store',['as' => 'flags_store', 'uses' => 'FlagController@store']);
        Route::get('/edit/{id}',['as' => 'flags_edit', 'uses' => 'FlagController@edit']);
        Route::post('/update/{id}',['as' => 'flags_update', 'uses' => 'FlagController@update']);
        Route::get('/delete/{id}', ['as' =>'flags_delete',    'uses' => 'FlagController@destroy']);
     });

    Route::group(['prefix' => 'logs', 'middleware' => 'web'],function(){
        Route::get('/',['as' => 'logs', 'uses' => 'LogController@index']);
        Route::get('/user/{id?}',['as' => 'user_logs', 'uses' => 'LogController@getUserLog']);
        Route::get('/delete/{id?}',['as' => 'delete_user_logs', 'uses' => 'LogController@delete']);
        Route::get('/clearlog',['as' => 'clear_logs', 'uses' => 'LogController@clearLog']);

    });
});

