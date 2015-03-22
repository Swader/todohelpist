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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::group(['middleware' => 'guest'], function () {

    Route::get('auth/login',
        function () {
            return view('auth.login');
        }
    );

    Route::get('auth/logoog',
        function () {
            return Socialize::with('google')->scopes(['email'])->redirect();
        }
    );
});

Route::post('auth/login', 'LoginController@loginRegular');
Route::get('auth/logoogprocess', 'LoginController@loginGoogle');
Route::get('auth/logout', 'LoginController@logout');

Route::group(['middleware' => 'auth'], function () {

});


//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
