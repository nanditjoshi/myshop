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

Route::get('/', function () { return view('pages.home');});
//Route::get('/step1', function () { return view('pages.step1'); });
//Route::get('/step2', function () { return view('pages.step2'); });
//Route::get('/step3', function () { return view('pages.step3'); });
//Route::get('/step4', function () { return view('pages.step4'); });
//Route::get('/listing', function () {return view('pages.listing');});
//Route::get('/listing-details', function () {return view('pages.listing-details');});
//Route::get('home', function () {   return view('welcome');});

//Route::get('/register', function () { return view('layout.admin.register'); });

Route::get('terms-condition', function () { return view('pages.terms_condition'); });
Route::get('contact-us', function () { return view('pages.contact_us'); });
Route::get('about-us', function () { return view('pages.about_us'); });
Route::get('flights', function () { return view('pages.flights'); });
Route::get('clear-cache', 'HomeController@clearCache')->name('clear-cache');
Route::post('/request-callback', 'HomeController@requestCallback');
Route::post('request-newsletter', 'HomeController@requestNewsletter');
Route::post('contactus', 'HomeController@addContactUs');

Route::post('/destinations', 'Destinations@destinations');

Route::get('api-check', 'ApiController@apiCheck')->name('api-check');
Route::get('curl-check', 'ApiController@checkCurl')->name('curl-check');
Route::get('update-property', 'ApiController@updateProperty')->name('update-property');


Route::post('listing','PropertyController@searchProperties')->name('property.list');
Route::get('fetch_data', 'PropertyController@fetch_data');
Route::get('fetch_data_group', 'PropertyController@fetch_data_group');
Route::get('listing-details/property-code/{propertycode}','PropertyController@propertyDetails')->name('property.details');
Route::get('listing-details/property-code-group/{propertycode}','PropertyController@propertyDetailsGroup')->name('property.detailsgroup');
Route::get('listing-details/property-code/{propertycode}','PropertyController@propertyDetails')->name('property.details');


//Log Route Go to http://myapp/logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::post('step1','BookingController@bookProperty')->name('propertybooking.booking');
Route::post('step2','BookingController@addOrderDetails')->name('propertybooking.passengerdetails');
Route::post('step3','BookingController@addPassengerDetails')->name('propertybooking.reviewBooking');
Route::post('paymentProcess','BookingController@reviewBookingDetails')->name('propertybooking.paymentProcess');
Route::post('viewbooking','BookingController@viewBooking')->name('propertybooking.viewbooking');
Route::post('/transfers', 'BookingController@getTransfers');

Route::post('Cancel','PaymentController@citsCancel')->name('propertypayment.citsCancel');
Route::post('Ok','PaymentController@citsOk')->name('propertypayment.citsOk');
Route::post('Notify','PaymentController@citsNotify')->name('propertypayment.citsNotify');


Auth::routes(['verify' => true]);

Route::get('/password/reset', 'Auth\ResetPasswordController@resetPassword');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('dashboard', 'Admin\DashboardController@getIndex')->name('dashboard');

/****** Users *********/
Route::resource('users', 'Admin\UserController');
Route::post('users/browse',['uses' => 'Admin\UserController@browse',  'as' => 'admin.users.browse']);
//Route::post('users/{id}',['uses' => 'Admin\UserController@update', 'as' => 'admin.users.update']);

/****** House Rules *********/
Route::resource('houserules', 'Admin\HouseRulesController');
Route::post('houserules/browse',['uses' => 'Admin\HouseRulesController@browse',  'as' => 'admin.houserules.browse']);

/****** Booking *********/
Route::resource('bookings', 'Admin\BookingController');
Route::post('bookings/browse',['uses' => 'Admin\BookingController@browse',  'as' => 'admin.bookings.browse']);
Route::get('bookings/{id}/details',['uses' => 'Admin\BookingController@details',  'as' => 'admin.bookings.details']);

/****** Property *********/
Route::resource('property', 'Admin\PropertyController');
Route::post('property/browse',['uses' => 'Admin\PropertyController@browse',  'as' => 'admin.propertys.browse']);
Route::get('property/{id}/show',['uses' => 'Admin\PropertyController@show',  'as' => 'admin.propertys.show']);
Route::get('property/{id}/images',['uses' => 'Admin\PropertyController@imagesindex',  'as' => 'admin.propertys.imagesindex']);
Route::post('property/addimages',['uses' => 'Admin\PropertyController@addimages',  'as' => 'admin.propertys.addimages']);
Route::get('property/{id}/delimages',['uses' => 'Admin\PropertyController@delimages',  'as' => 'admin.propertys.delimages']);
