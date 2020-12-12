<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {


    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/resetCode', 'AuthController@reset_code');
    Route::post('/resetPass', 'AuthController@reset_pass');
    Route::post('/activateCode', 'AuthController@activate_code');
    // onboadings
    Route::apiResource('onboadings', 'OnboadingsApiController');
    // Countries
    Route::apiResource('countries', 'CountriesApiController');
    // Cities
    Route::apiResource('cities', 'CityApiController');
    // Currencies
    Route::apiResource('currencies', 'CurrencyApiController');
    // Slide Shows
    Route::apiResource('slide-shows', 'SlideShowApiController');
    // All Ads
    Route::get('all-ads/{type}/all', 'AllAdsApiController@index');
    Route::get('all-ads/{id}', 'AllAdsApiController@show');
    // Restaurants
    Route::apiResource('restaurants', 'RestaurantsApiController');
    // Categories of Restaurants
    Route::get('restaurants/{id}/categories', 'CategoryApiController@index');
    Route::get('categories/{id}', 'CategoryApiController@show');
    // Home
    Route::get('home', 'HomeApiController@index');
    // Payment Methods
    Route::apiResource('payment-methods', 'PaymentMethodsApiController');
    // Deliveries
    Route::apiResource('deliveries', 'DeliveryApiController');
    // Delivery Companies
    Route::apiResource('delivery-companies', 'DeliveryCompanyApiController');

    // Carbrands
    Route::apiResource('carbrands', 'CarbrandApiController');

    // Type Of Cars
    Route::apiResource('type-of-cars', 'TypeOfCarApiController');

    // Car Colors
    Route::apiResource('car-colors', 'CarColorApiController');
    // Cansel Reasons
    Route::apiResource('cancel-reasons', 'CancelReasonApiController');
     // Faqs
    Route::apiResource('faqs', 'FaqApiController');
});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api']], function () {

    Route::post('/logout', 'AuthController@logout');
    Route::get('/profile', 'AuthController@user');
    Route::post('/updateProfile', 'AuthController@update_profile');
    Route::post('/updatePassword', 'AuthController@update_passwprd');

    // Orders
    Route::apiResource('orders', 'OrderApiController');
    Route::post('orders/{id}/cancel', 'OrderApiController@cancel');
    // Car Lists
    Route::apiResource('car-lists', 'CarListApiController');
    // Carts
    Route::apiResource('carts', 'CartApiController');
    Route::post('carts/{id}/edit', 'CartApiController@update');

    // Addresses
    Route::apiResource('addresses', 'AddressApiController');
    Route::post('addresses/{id}/edit', 'AddressApiController@update');

    // Favorites
    Route::apiResource('favorites', 'FavoriteApiController', ['except' => ['index', 'show']]);
    Route::get('favorites/{type}', 'FavoriteApiController@index');

    // Reportings
    Route::apiResource('reportings', 'ReportingApiController');
    Route::post('notes', 'ReportingApiController@note');
});
