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


Route::redirect('/', 'http://guestcompass.nl/', 307);


Route::get('/test', ['name' => 'test', 'uses' => 'Login@getData', 'middleware' => 'web']);

Route::post('/auth', ['name' => 'test', 'uses' => 'ClientAuthController@getAuth', 'middleware' => 'web']);


Route::get('/up', function () {


});