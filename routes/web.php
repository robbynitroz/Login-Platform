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
    Route::get('/newsfeeds/get/{hotel_name?}',
        ['uses' => 'Newsfeed\NewsfeedController@index', 'middleware' => ['web']])->name('newsfeed');

};

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
Route::get('/dashboard/{page?}/{argument?}/{secondary?}/{andevenmore?}',
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

Route::post('/template/clone',
    ['uses' => 'TemplateController@cloneTemplate', 'middleware' => ['web', 'auth']])->name('clone_template');

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

Route::get('/mikrotik/status/{id?}',
    ['uses' => 'NasController@mikrotikStatus', 'middleware' => ['web', 'auth']])->name('get_mikrotik_status');

//Emails list
Route::get('/emails/{token}',
    ['uses' => 'EmailController@emailList', 'middleware' => ['web', 'isblocked']])->name('get_email_list');

Route::get('/emails/', function () {
    return view('auth.auth');
})->name('get_email_list_page')->middleware('web');

//Newsfeed URLs
Route::post('/newsfeeds/group/add', [
    'uses' => 'Newsfeed\NewsFeedGroupController@addGroup',
    'middleware' => ['web', 'auth']
])->name('add_newsfeed_group');

Route::post('/newsfeeds/group/edit', [
    'uses' => 'Newsfeed\NewsFeedGroupController@editGroup',
    'middleware' => ['web', 'auth']
])->name('edit_newsfeed_group');

Route::delete('/newsfeeds/group/delete/{id}', [
    'uses' => 'Newsfeed\NewsFeedGroupController@deleteGroup',
    'middleware' => ['web', 'auth']
])->name('delete_newsfeed_group');

Route::get('/newsfeeds/groups', [
    'uses' => 'Newsfeed\NewsFeedGroupController@getGroups',
    'middleware' => ['web', 'auth']
])->name('get_newsfeed_groups');

Route::get('/newsfeeds/group/{id}', [
    'uses' => 'Newsfeed\NewsFeedGroupController@getGroupByID',
    'middleware' => ['web', 'auth']
])->name('get_newsfeed_groups');

//News feed cards
Route::get('/newsfeeds/cards/data', [
    'uses' => 'Newsfeed\NewsfeedController@getNecessaryData',
    'middleware' => ['web', 'auth']
])->name('get_newsfeed_card_data');

Route::post('/newsfeeds/cards/new', [
    'uses' => 'Newsfeed\NewsfeedController@newCard',
    'middleware' => ['web', 'auth']
])->name('create_newsfeed_card');

Route::post('/newsfeeds/media/{id}', [
    'uses' => 'Newsfeed\NewsfeedController@editCardMedia',
    'middleware' => ['web', 'auth']
])->name('edit_newsfeed_card_media');

Route::get('/newsfeeds/cards', [
    'uses' => 'Newsfeed\NewsfeedController@getCards',
    'middleware' => ['web', 'auth']
])->name('all_newsfeed_cards');

Route::delete('/newsfeeds/card/delete/{id}', [
    'uses' => 'Newsfeed\NewsfeedController@deleteCard',
    'middleware' => ['web', 'auth']
])->name('delete_newsfeed_card');

Route::get('/newsfeeds/card/{id}', [
    'uses' => 'Newsfeed\NewsfeedController@getCard',
    'middleware' => ['web', 'auth']
])->name('get_newsfeed_card');

Route::post('/newsfeeds/card/edit/{id}', [
    'uses' => 'Newsfeed\NewsfeedController@editCard',
    'middleware' => ['web', 'auth']
])->name('edit_newsfeed_card');

//Settings routes
Route::get('/settings/emails', [
    'uses' => 'SettingController@getEmailsSettings',
    'middleware' => ['web', 'auth']
])->name('get_emails_settings');

Route::get('/settings/email/{id}', [
    'uses' => 'SettingController@getEmailsSettingsByID',
    'middleware' => ['web', 'auth']
])->name('get_emails_setting_by_id');

Route::post('/settings/emails/add', [
    'uses' => 'SettingController@newEmailsSettings',
    'middleware' => ['web', 'auth']
])->name('new_emails_settings');

Route::post('/settings/emails/edit/{id}', [
    'uses' => 'SettingController@editEmailsSettings',
    'middleware' => ['web', 'auth']
])->name('edit_emails_settings');

Route::delete('/settings/delete/{id}', [
    'uses' => 'SettingController@deleteSettingByID',
    'middleware' => ['web', 'auth']
])->name('delete_setting_by_id');

Route::get('/settings/utilisation', [
    'uses' => 'SettingController@getUtilisationSettings',
    'middleware' => ['web', 'auth']
])->name('get_utilisation_settings');

Route::post('/settings/utilisation/set', [
    'uses' => 'SettingController@storeUtilisationSettings',
    'middleware' => ['web', 'auth']
])->name('store_utilisation_settings');

Route::post('/settings/management', [
    'uses' => 'SettingController@serverManagement',
    'middleware' => ['web', 'auth']
])->name('server_management');

Route::get('user', [
    'uses' => 'UserController@getCurrentUser',
    'middleware' => ['web', 'auth']
])->name('current_user');

Route::post('/user/avatar/', [
    'uses' => 'UserController@setCurrentUserAvatar',
    'middleware' => ['web', 'auth']
])->name('set_current_user_avatar');

Route::post('/user/change-data/', [
    'uses' => 'UserController@setCurrentUserData',
    'middleware' => ['web', 'auth']
])->name('set_current_user_data');

Route::get('/settings/emails/count', [
    'uses' => 'SettingController@numOfEmailsInDB',
    'middleware' => ['web', 'auth']
])->name('count_emails_for_groups');



