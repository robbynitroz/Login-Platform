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


//Newsfeed
$newsfeed = function () {
    Route::get('/{hotel_name?}', function () {
        return view('newsfeed.index');
    });

    //Newsfeed API
    Route::get('/newsfeeds/{hotel_name}',
        ['uses' => 'Newsfeed\NewsfeedController@index', 'middleware' => ['web']])->name('newsfeed');
};


Route::group(['domain' => 'cmsfront.loc'], $newsfeed);
Route::group(['domain' => 'cmsfrontdev.guestcompass.nl'], $newsfeed);
Route::group(['domain' => 'cmsfront.guestcompass.nl'], $newsfeed);


//Main URN
Route::get('/', function () {
    return view('auth.auth');
})->name('base_URL');

//Clients | MikroTik Users auth page
Route::get('/guest', ['uses' => 'MikrotikLogin@getData', 'middleware' => 'web'])->name('mikrotik_login');
Route::get('/guest/api.php', function () {
    return redirect('/mikrotik/timeout');
})->name('mikrotik_timeout_redirect');


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

//Dashboard universal route
Route::get('/dashboard/{page?}/{argument?}/{secondary?}',
    ['uses' => 'DashboardController@index', 'middleware' => ['web', 'auth']])->name('dashboard');

// Hotel Routes for Dashboard
Route::get('/hotels', ['uses' => 'HotelController@getHotels', 'middleware' => ['web', 'auth']])->name('hotels');
Route::post('/hotel', ['uses' => 'HotelController@newHotel', 'middleware' => ['web', 'auth']])->name('create_hotel');
Route::get('/hotel/{id}',
    ['uses' => 'HotelController@getHotelAdmin', 'middleware' => ['web', 'auth']])->name('get_hotel');
Route::put('/hotel/{id}', ['uses' => 'HotelController@editHotel', 'middleware' => ['web', 'auth']])->name('edit_hotel');
Route::post('/hotel/files/{id}',
    ['uses' => 'HotelController@editHotelFiles', 'middleware' => ['web', 'auth']])->name('edit_hotel_files');
Route::delete('/hotel/{id}',
    ['uses' => 'HotelController@deleteHotel', 'middleware' => ['web', 'auth']])->name('delete_hotels');
Route::get('/hotel/templates/{id}',
    ['uses' => 'HotelController@getHotelTemplates', 'middleware' => ['web', 'auth']])->name('hotel_templates');
// Hotel routes end

//Templates and login method routes
Route::get('/template/methods',
    ['uses' => 'TemplateController@getLoginMethods', 'middleware' => ['web', 'auth']])->name('template_methods');
Route::post('/template/add',
    ['uses' => 'TemplateController@newTemplate', 'middleware' => ['web', 'auth']])->name('create_template');
Route::post('/template/edit/{id}',
    ['uses' => 'TemplateController@editTemplate', 'middleware' => ['web', 'auth']])->name('edit_template');
Route::delete('/template/{id}',
    ['uses' => 'TemplateController@delete', 'middleware' => ['web', 'auth']])->name('delete_template');
Route::get('/template/{id}',
    ['uses' => 'TemplateController@getTemplateById', 'middleware' => ['web', 'auth']])->name('get_template_by_id');
Route::post('/template/media/{id}',
    ['uses' => 'TemplateController@mediaFiles', 'middleware' => ['web', 'auth']])->name('template_media');

//Reserved templates
Route::post('/template/set-reserved',
    ['uses' => 'TemplateController@setReserved', 'middleware' => ['web', 'auth']])->name('set_reserved_template');
Route::delete('/template/reserved/{id}', [
    'uses' => 'TemplateController@unsetOldReserved',
    'middleware' => ['web', 'auth']
])->name('delete_reserved_template');

Route::post('/template/preview',
    ['uses' => 'TemplateController@preparePreview', 'middleware' => ['web', 'auth']])->name('prepare_preview');
Route::post('/template/activate',
    ['uses' => 'TemplateController@activate', 'middleware' => ['web', 'auth']])->name('activate_template');
Route::get('/preview/{id}', ['uses' => 'TemplateController@preview', 'middleware' => ['web', 'auth']])->name('preview');


//Routers
Route::get('/routers', ['uses' => 'NasController@getAllRouters', 'middleware' => ['web', 'auth']])->name('routers');
Route::get('/router/{id}',
    ['uses' => 'NasController@getRouterByID', 'middleware' => ['web', 'auth']])->name('routers_by_id');
Route::get('/routers/{hotel_id}',
    ['uses' => 'NasController@getHotelRouters', 'middleware' => ['web', 'auth']])->name('routers_by_hotel_id');
Route::post('/router/add', ['uses' => 'NasController@addRouter', 'middleware' => ['web', 'auth']])->name('add_router');
Route::delete('/router/{id}',
    ['uses' => 'NasController@deleteRouter', 'middleware' => ['web', 'auth']])->name('delete_router');
Route::put('/router/{id}',
    ['uses' => 'NasController@editRouter', 'middleware' => ['web', 'auth']])->name('edit_router');


//Special URLs
Route::get('/mikrotik/timeout',
    ['uses' => 'MikrotikLogin@getTimeOut', 'middleware' => ['web', 'auth']])->name('mikrotik_timeout');
Route::get('/mikrotik/connect',
    ['uses' => 'MikrotikLogin@mikrotikTestConnect', 'middleware' => ['web', 'auth']])->name('test');
Route::get('/mikrotik/status/{id?}',
    ['uses' => 'NasController@mikrotikStatus', 'middleware' => ['web', 'auth']])->name('get_mikrotik_status');









