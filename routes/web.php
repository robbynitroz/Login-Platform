<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login.com block
Route::group(array('domain' => 'login.com'), function () {
    Route::get('/', ['name' => 'Login', 'uses' => 'Login@getData']);
});


//Auth methods
Route::prefix('/auth')->group(function () {
    //By Email
    Route::post('/email', ['name' => 'email_auth', 'uses' => 'ClientAuthController@getEmailAuth', 'middleware' => 'web']);
    Route::post('/login', ['name' => 'login_auth', 'uses' => 'ClientAuthController@getLoginAuth', 'middleware' => 'web']);

});


Route::redirect('/', 'http://guestcompass.nl/', 307);


Route::get('/test', ['name' => 'test', 'uses' => 'Login@getData', 'middleware' => 'web']);




