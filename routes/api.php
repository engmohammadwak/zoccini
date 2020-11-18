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
    // Home
    Route::get('home', 'HomeApiController@index');
    // Payment Methods
    Route::apiResource('payment-methods', 'PaymentMethodsApiController');
    // Deliveries
    Route::apiResource('deliveries', 'DeliveryApiController');
    // Delivery Companies
    Route::apiResource('delivery-companies', 'DeliveryCompanyApiController');

});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api']], function () {

    Route::post('/logout', 'AuthController@logout');
    Route::get('/profile', 'AuthController@user');
    Route::post('/updateProfile', 'AuthController@update_profile');
    Route::post('/updatePassword', 'AuthController@update_passwprd');




    // Categories
    Route::apiResource('categories', 'CategoryApiController');

    // Items
    Route::post('items/media', 'ItemApiController@storeMedia')->name('items.storeMedia');
    Route::apiResource('items', 'ItemApiController');

    // Sitting Areas
    Route::apiResource('sitting-areas', 'SittingAreaApiController');


    // Reportings
    Route::apiResource('reportings', 'ReportingApiController');

    // Rates
    Route::apiResource('rates', 'RateApiController');

    // Carts
    Route::apiResource('carts', 'CartApiController');

    // Addresses
    Route::apiResource('addresses', 'AddressApiController');

    // Save Credit Cards
    Route::apiResource('save-credit-cards', 'SaveCreditCardApiController');



    // Subscription Packages
    Route::apiResource('subscription-packages', 'SubscriptionPackagesApiController');

    // Ads Categories
    Route::apiResource('ads-categories', 'AdsCategoryApiController');


    // Orders
    Route::apiResource('orders', 'OrderApiController');

    // Extras
    Route::apiResource('extras', 'ExtraApiController');

    // Order Types
    Route::apiResource('order-types', 'OrderTypeApiController');

    // Order Statuses
    Route::apiResource('order-statuses', 'OrderStatusApiController');

    // Otherbranches
    Route::apiResource('otherbranches', 'OtherbranchApiController');

    // Cansel Reasons
    Route::apiResource('cansel-reasons', 'CanselReasonApiController');

    // Favorites
    Route::apiResource('favorites', 'FavoriteApiController');

    // Faqs
    Route::apiResource('faqs', 'FaqApiController');

    // Tickets
    Route::apiResource('tickets', 'TicketApiController');

    // Ticket Statuses
    Route::apiResource('ticket-statuses', 'TicketStatusApiController');

    // Coupons
    Route::apiResource('coupons', 'CouponApiController');

    // Notifications
    Route::apiResource('notifications', 'NotificationApiController');

    // Subscription Vips
    Route::apiResource('subscription-vips', 'SubscriptionVipApiController');

    // Points
    Route::apiResource('points', 'PointApiController');

    // Point Types
    Route::apiResource('point-types', 'PointTypeApiController');

    // Onborderings
    Route::post('onborderings/media', 'OnborderingApiController@storeMedia')->name('onborderings.storeMedia');
    Route::apiResource('onborderings', 'OnborderingApiController');

    // Tables
    Route::apiResource('tables', 'TablesApiController');

    // Table Statuses
    Route::apiResource('table-statuses', 'TableStatusApiController');

    // Subscription Users
    Route::apiResource('subscription-users', 'SubscriptionUserApiController');
});
