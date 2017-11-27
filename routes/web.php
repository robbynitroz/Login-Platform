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
    return view('auth.auth');
})->name('base_URL');

//Clients | MikroTik Users auth page
Route::get('/clients', ['uses' => 'MikrotikLogin@getData', 'middleware' => 'web'])->name('mikrotik_login');



//Mikrotik Auth URNs
Route::prefix('/auth')->group(function () {
    //By Email
    Route::post('/email',
        ['uses' => 'ClientAuthController@getEmailAuth', 'middleware' => 'web'])->name('email_auth');
    Route::post('/login',
        ['uses' => 'ClientAuthController@getLoginAuth', 'middleware' => 'web'])->name('email_auth');
    Route::post('/facebook',
        ['uses' => 'ClientAuthController@getEmailAuth', 'middleware' => 'web'])->name('fb_auth');

});





//Auth URNs
Auth::routes();

Route::get('/dashboard/{param?}/{argument?}', ['uses'=>'DashboardController@index', 'middleware'=>['web', 'auth']])->name('dashboard');



Route::get('/hotels', ['uses'=>'HotelController@getHotels', 'middleware'=>['web', 'auth']])->name('hotels');
Route::delete('/hotels/{id}', ['uses'=>'HotelController@deleteHotel', 'middleware'=>['web', 'auth']])->name('delete_hotels');


/*Route::get('/test/', function (){



})->name('test');*/


