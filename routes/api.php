<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {

    Route::get('/redirect', 'AuthController@redirectToProvider');
    Route::get('/callback', 'AuthController@handleProviderCallback');

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('social-login', 'AuthController@social_login');

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
    Route::get('all-ads/{id}/ads_subscription', 'AllAdsApiController@ads_subscription');
    Route::get('all-ads-winner', 'AllAdsApiController@winner');

    // Restaurants
    Route::apiResource('restaurants', 'RestaurantsApiController');
    Route::get('restaurants/{id}/rate', 'RestaurantsApiController@show_rate');
    Route::get('restaurants/{id}/waiting', 'RestaurantsApiController@waiting');
    // Categories of Restaurants
    Route::get('restaurants/{id}/categories', 'CategoryApiController@index');
    Route::get('restaurants/{id}/full_categories', 'CategoryApiController@index_all_food');
    Route::get('categories/{id}', 'CategoryApiController@show');
    //get all extra foods
    Route::get('food/{id}/extra', 'ItemApiController@food_extra');
    Route::get('food/{id}', 'ItemApiController@show');

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

    // setting
    Route::get('setting', 'HomeApiController@setting');



    //view queue

    Route::get('view_queue/{phone}' , 'RestaurantsApiController@view_queue');
});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api']], function () {

    Route::post('/logout', 'AuthController@logout');
    Route::get('/profile', 'AuthController@user');
    Route::post('/updateProfile', 'AuthController@update_profile');
    Route::post('/updatePassword', 'AuthController@update_passwprd');
    Route::post('/updateEmail', 'AuthController@update_email');
    Route::post('/updatePhone', 'AuthController@update_phone');

    // Delete account
    Route::post('/delete-account', 'AuthController@deleteAccount');

    // Orders
    Route::apiResource('orders', 'OrderApiController');
    Route::post('orders/{id}/cancel', 'OrderApiController@cancel');
    Route::post('orders/{id}/confirm', 'OrderApiController@confirm');
    Route::post('orders/{id}/update', 'OrderApiController@update');
    Route::post('orders/{id}/finished', 'OrderApiController@finished');
    Route::post('orders/{id}/arrival', 'OrderApiController@arrival');
    Route::post('orders/{id}/rating', 'OrderApiController@rating');
    Route::post('orders/{id}/skip', 'OrderApiController@skip');
    Route::get('last_order', 'OrderApiController@last_order');
    Route::post('share', 'OrderApiController@share');

    //check_coupon
    Route::post('check_coupon', 'CouponApiController@check_coupon');

    //notification
    Route::apiResource('notification', 'NotificationApiController');
    // Car Lists
    Route::apiResource('car-lists', 'CarListApiController');
    // Carts
    Route::apiResource('carts', 'CartApiController');
    Route::post('carts/{id}/edit', 'CartApiController@update');
    Route::post('carts/{id}/price', 'CartApiController@price');

    // Addresses
    Route::apiResource('addresses', 'AddressApiController');
    Route::post('addresses/{id}/edit', 'AddressApiController@update');



    //pyment
    Route::get('payment/{price}', 'OrderApiController@payment');


    // Contact
    Route::apiResource('contact', 'ContactApiController');

    // Ticket
    Route::apiResource('ticket', 'TicketApiController');
    Route::post('ticket/{id}/replay', 'TicketApiController@replay');
    Route::get('ticket/{id}/message', 'TicketApiController@message');
    Route::post('ticket/{id}/rate', 'TicketApiController@rate');

    // Favorites
    Route::apiResource('favorites', 'FavoriteApiController', ['except' => ['index', 'show']]);
    Route::get('favorites/{type}', 'FavoriteApiController@index');

    // Reportings
    Route::apiResource('reportings', 'ReportingApiController');
    Route::post('notes', 'ReportingApiController@note');


    // Point
    Route::apiResource('point', 'PointApiController');




    //////////////////////////////////////////////////
    ///                   restaurants app
    /// /////////////////////////////////////////////

    Route::get('restaurants_home' , 'RestaurantsApiController@restaurants_home');
    Route::get('order_restaurant' , 'OrderApiController@order_restaurant');
    Route::get('table' , 'TableApiController@index');
    Route::get('table/{id}/change_status' , 'TableApiController@change_status');
    Route::get('table_release_all' , 'TableApiController@release_all');
    Route::get('show_order/{id}' , 'OrderApiController@show_Restaurants_app');
    Route::post('order/{id}/accept' , 'OrderApiController@accept');
    Route::post('order/{id}/confirm_restaurant' , 'OrderApiController@confirm_restaurant');
    Route::post('order/{id}/cancel_restaurant' , 'OrderApiController@cancel_restaurant');

});
