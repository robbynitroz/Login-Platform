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


//Main URN
Route::get('/', function (){

    echo $_SERVER['REMOTE_ADDR'];

})->name('base_URL');

//Clients | Mikrotik Users auth page
Route::get('/clients', ['name' => 'Login', 'uses' => 'Login@getData', 'middleware' => 'web']);






//Mikrotik Auth URNs
Route::prefix('/auth')->group(function () {
    //By Email
    Route::post('/email',
        ['name' => 'email_auth', 'uses' => 'ClientAuthController@getEmailAuth', 'middleware' => 'web']);
    Route::post('/login',
        ['name' => 'login_auth', 'uses' => 'ClientAuthController@getLoginAuth', 'middleware' => 'web']);
    Route::post('/facebook',
        ['name' => 'fb_auth', 'uses' => 'ClientAuthController@getEmailAuth', 'middleware' => 'web']);

});


//Route::redirect('/', 'http://guestcompass.nl/', 307);


//Auth URNs
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


