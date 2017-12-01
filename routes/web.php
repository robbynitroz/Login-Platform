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

Route::get('/dashboard/{page?}/{argument?}/{secondary?}', ['uses'=>'DashboardController@index', 'middleware'=>['web', 'auth']])->name('dashboard');


Route::get('/hotels', ['uses'=>'HotelController@getHotels', 'middleware'=>['web', 'auth']])->name('hotels');
Route::get('/hotel/{id}', ['uses'=>'HotelController@getHotelAdmin', 'middleware'=>['web', 'auth']])->name('get_hotel');
Route::put('/hotel/{id}', ['uses'=>'HotelController@editHotel', 'middleware'=>['web', 'auth']])->name('edit_hotel');
Route::post('/hotel/files/{id}', ['uses'=>'HotelController@editHotelFiles', 'middleware'=>['web', 'auth']])->name('edit_hotel_files');
Route::delete('/hotel/{id}', ['uses'=>'HotelController@deleteHotel', 'middleware'=>['web', 'auth']])->name('delete_hotels');


/*Route::get('/test/', function (){



})->name('test');*/


