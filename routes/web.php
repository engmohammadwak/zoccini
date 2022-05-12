<?php

//Route::redirect('/', '/login');
Route::get('/clear', function () {

    $exitCode = \Illuminate\Support\Facades\Artisan::call('view:clear');
    $exitCode = \Illuminate\Support\Facades\Artisan::call('config:cache');
    $exitCode = \Illuminate\Support\Facades\Artisan::call('config:clear');

});

Route::get('/', 'HomeController@index')->name('home_loop');
Route::get('/AboutUs', function () {
    return view('about_us');
});
Route::get('/becomePartner', 'HomeController@become_partner');
Route::post('/join_loop_post', 'HomeController@join_loop_post');
Route::get('/becomePartner_2', function () {
    return view('become_partner_2');
});

Route::post('/become_partner_store', 'HomeController@become_partner_store');
Route::get('/become_partner_store', 'HomeController@index');
Route::post('/update_profile', 'HomeController@update_profile');
Route::get('/update_profile_payment', 'HomeController@update_profile_payment');
Route::get('/map', 'HomeController@map');

Route::get('/our_profile', function () {
    return view('our_profile');
});
Route::get('/privacy_policy', function () {
    return view('privacy_policy');
});
Route::get('/terms_of_use', function () {
    return view('terms_of_use');
});
Route::get('/client_terms', function () {
    return view('client_terms');
});

Route::get('/lhome', function () {
    $plan = \App\Models\SubscriptionPackage::all();
    $subscription = \App\Models\ReferralSubscription::where('user_loop_id' , \Illuminate\Support\Facades\Auth::id())->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth()->subMonth()->toDateString())->get();
    return view('loop_home' , compact('plan' , 'subscription'));
});

Route::get('/history', function () {
    $plan = \App\Models\SubscriptionPackage::all();
    $subscription = \App\Models\ReferralSubscription::where('user_loop_id' , \Illuminate\Support\Facades\Auth::id())->get();
    return view('history' , compact('plan' , 'subscription'));
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/id_verification', function () {
    $user = \App\Models\Loopuser::where('user_id' , \Illuminate\Support\Facades\Auth::id())->first();
    return view('id_verification' , compact('user'));
});

Route::get('/payout_method', function () {
    $user = \App\Models\Loopuser::with('bank')->where('user_id' , \Illuminate\Support\Facades\Auth::id())->first();
    return view('payout_method' , compact('user'));
});

Route::get('/success', function () {
    return view('success');
});

Route::get('/loop_join', function () {
    $country = \App\Models\Country::where('status' , 1)->get();
    $city = \App\Models\City::where('status' , 1)->get();
    return view('join_loop' , compact('country' , 'city'));
});

Route::get('/plan', function () {

    $plan = \App\Models\SubscriptionPackage::all();
    return view('plan' , compact('plan'));
});



Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }


    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');
    Route::get('users/{id}/order', 'UsersController@user_order')->name('users.user_order');
    Route::get('users/{type}/type', 'UsersController@type')->name('users.user_type');

    // employees
    Route::delete('employees/destroy', 'EmployeesController@massDestroy')->name('employees.massDestroy');
    Route::resource('employees', 'EmployeesController');

    // User Statuses
    Route::delete('user-statuses/destroy', 'UserStatusController@massDestroy')->name('user-statuses.massDestroy');
    Route::resource('user-statuses', 'UserStatusController');

    // Slide Shows
    Route::delete('slide-shows/destroy', 'SlideShowController@massDestroy')->name('slide-shows.massDestroy');
    Route::post('slide-shows/media', 'SlideShowController@storeMedia')->name('slide-shows.storeMedia');
    Route::post('slide-shows/ckmedia', 'SlideShowController@storeCKEditorImages')->name('slide-shows.storeCKEditorImages');
    Route::resource('slide-shows', 'SlideShowController');

    // Restaurants
    Route::delete('restaurants/destroy', 'RestaurantsController@massDestroy')->name('restaurants.massDestroy');
    Route::post('restaurants/media', 'RestaurantsController@storeMedia')->name('restaurants.storeMedia');
    Route::post('restaurants/ckmedia', 'RestaurantsController@storeCKEditorImages')->name('restaurants.storeCKEditorImages');
    Route::resource('restaurants', 'RestaurantsController');
    Route::get('restaurants_register', 'RestaurantsController@index');
    Route::get('restaurants/{id}/active', 'RestaurantsController@active')->name('restaurants.active');
    Route::get('restaurants/{id}/order', 'RestaurantsController@restaurant_order')->name('restaurants.restaurant_order');

    //image
    Route::get('deleteImage/{id}', 'ImagesController@deleteImage')->name('deleteImage');

    // Deliveries
    Route::delete('deliveries/destroy', 'DeliveryController@massDestroy')->name('deliveries.massDestroy');
    Route::resource('deliveries', 'DeliveryController');

    // Payment Methods
    Route::delete('payment-methods/destroy', 'PaymentMethodsController@massDestroy')->name('payment-methods.massDestroy');
    Route::post('payment-methods/media', 'PaymentMethodsController@storeMedia')->name('payment-methods.storeMedia');
    Route::post('payment-methods/ckmedia', 'PaymentMethodsController@storeCKEditorImages')->name('payment-methods.storeCKEditorImages');
    Route::resource('payment-methods', 'PaymentMethodsController');

    // Categories
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoryController');

    // Items
    Route::delete('items/destroy', 'ItemController@massDestroy')->name('items.massDestroy');
    Route::post('items/media', 'ItemController@storeMedia')->name('items.storeMedia');
    Route::post('items/ckmedia', 'ItemController@storeCKEditorImages')->name('items.storeCKEditorImages');
    Route::resource('items', 'ItemController');
    Route::get('items/{id}/extra', 'ExtraController@index')->name('items.extra');
    Route::get('items/{id}/create_extra', 'ExtraController@create')->name('items.extra.create');


    // Extras
    Route::delete('extras/destroy', 'ExtraController@massDestroy')->name('extras.massDestroy');
    Route::resource('extras', 'ExtraController');

    // Sitting Areas
    Route::delete('sitting-areas/destroy', 'SittingAreaController@massDestroy')->name('sitting-areas.massDestroy');
    Route::resource('sitting-areas', 'SittingAreaController');

    // Delivery Companies
    Route::delete('delivery-companies/destroy', 'DeliveryCompanyController@massDestroy')->name('delivery-companies.massDestroy');
    Route::resource('delivery-companies', 'DeliveryCompanyController');

    // Reportings
    Route::delete('reportings/destroy', 'ReportingController@massDestroy')->name('reportings.massDestroy');
    Route::resource('reportings', 'ReportingController');

    // Rates
    Route::delete('rates/destroy', 'RateController@massDestroy')->name('rates.massDestroy');
    Route::resource('rates', 'RateController');

    // Carts
    Route::delete('carts/destroy', 'CartController@massDestroy')->name('carts.massDestroy');
    Route::resource('carts', 'CartController');

    // Addresses
    Route::delete('addresses/destroy', 'AddressController@massDestroy')->name('addresses.massDestroy');
    Route::resource('addresses', 'AddressController');

    // Save Credit Cards
    Route::delete('save-credit-cards/destroy', 'SaveCreditCardController@massDestroy')->name('save-credit-cards.massDestroy');
    Route::resource('save-credit-cards', 'SaveCreditCardController');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');

    // Cities
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    // Currencies
    Route::delete('currencies/destroy', 'CurrencyController@massDestroy')->name('currencies.massDestroy');
    Route::resource('currencies', 'CurrencyController');

    // Subscription Packages
    Route::delete('subscription-packages/destroy', 'SubscriptionPackagesController@massDestroy')->name('subscription-packages.massDestroy');
    Route::resource('subscription-packages', 'SubscriptionPackagesController');

    // Ads Categories
    Route::delete('ads-categories/destroy', 'AdsCategoryController@massDestroy')->name('ads-categories.massDestroy');
    Route::resource('ads-categories', 'AdsCategoryController');

    // All Ads
    Route::delete('all-ads/destroy', 'AllAdsController@massDestroy')->name('all-ads.massDestroy');
    Route::post('all-ads/media', 'AllAdsController@storeMedia')->name('all-ads.storeMedia');
    Route::post('all-ads/ckmedia', 'AllAdsController@storeCKEditorImages')->name('all-ads.storeCKEditorImages');
    Route::resource('all-ads', 'AllAdsController');

    // Orders
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');

    // Order Types
    Route::delete('order-types/destroy', 'OrderTypeController@massDestroy')->name('order-types.massDestroy');
    Route::resource('order-types', 'OrderTypeController');

    // Order Statuses
    Route::delete('order-statuses/destroy', 'OrderStatusController@massDestroy')->name('order-statuses.massDestroy');
    Route::resource('order-statuses', 'OrderStatusController');

    // Otherbranches
    Route::delete('otherbranches/destroy', 'OtherbranchController@massDestroy')->name('otherbranches.massDestroy');
    Route::resource('otherbranches', 'OtherbranchController');

    // Cansel Reasons
    Route::delete('cansel-reasons/destroy', 'CanselReasonController@massDestroy')->name('cansel-reasons.massDestroy');
    Route::resource('cansel-reasons', 'CanselReasonController');

    // Favorites
    Route::delete('favorites/destroy', 'FavoriteController@massDestroy')->name('favorites.massDestroy');
    Route::resource('favorites', 'FavoriteController');

    // Faqs
    Route::delete('faqs/destroy', 'FaqController@massDestroy')->name('faqs.massDestroy');
    Route::resource('faqs', 'FaqController');

    // Tickets
    Route::delete('tickets/destroy', 'TicketController@massDestroy')->name('tickets.massDestroy');
    Route::resource('tickets', 'TicketController');
    Route::post('tickets/{id}/replay', 'TicketController@replay');
    Route::get('tickets/{id}/close', 'TicketController@close')->name('tickets.close');

    // Ticket Statuses
    Route::delete('ticket-statuses/destroy', 'TicketStatusController@massDestroy')->name('ticket-statuses.massDestroy');
    Route::resource('ticket-statuses', 'TicketStatusController');

    // Coupons
    Route::delete('coupons/destroy', 'CouponController@massDestroy')->name('coupons.massDestroy');
    Route::resource('coupons', 'CouponController');

    // Notifications
    Route::delete('notifications/destroy', 'NotificationController@massDestroy')->name('notifications.massDestroy');
    Route::resource('notifications', 'NotificationController');

    // Subscription Vips
    Route::delete('subscription-vips/destroy', 'SubscriptionVipController@massDestroy')->name('subscription-vips.massDestroy');
    Route::resource('subscription-vips', 'SubscriptionVipController');

    // Points
    Route::delete('points/destroy', 'PointController@massDestroy')->name('points.massDestroy');
    Route::resource('points', 'PointController');

    // Point Types
    Route::delete('point-types/destroy', 'PointTypeController@massDestroy')->name('point-types.massDestroy');
    Route::resource('point-types', 'PointTypeController');

    // Onborderings
    Route::delete('onborderings/destroy', 'OnborderingController@massDestroy')->name('onborderings.massDestroy');
    Route::post('onborderings/media', 'OnborderingController@storeMedia')->name('onborderings.storeMedia');
    Route::post('onborderings/ckmedia', 'OnborderingController@storeCKEditorImages')->name('onborderings.storeCKEditorImages');
    Route::resource('onborderings', 'OnborderingController');

    // Tables
    Route::delete('tables/destroy', 'TablesController@massDestroy')->name('tables.massDestroy');
    Route::resource('tables', 'TablesController');

    // Table Statuses
    Route::delete('table-statuses/destroy', 'TableStatusController@massDestroy')->name('table-statuses.massDestroy');
    Route::resource('table-statuses', 'TableStatusController');

    // Subscription Users
    Route::delete('subscription-users/destroy', 'SubscriptionUserController@massDestroy')->name('subscription-users.massDestroy');
    Route::resource('subscription-users', 'SubscriptionUserController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
    Route::get('user-alert/read', 'UserAlertsController@read');

    // Settings
    Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingController');

    // Carbrands
    Route::delete('carbrands/destroy', 'CarbrandController@massDestroy')->name('carbrands.massDestroy');
    Route::resource('carbrands', 'CarbrandController');

    // Type Of Cars
    Route::delete('type-of-cars/destroy', 'TypeOfCarController@massDestroy')->name('type-of-cars.massDestroy');
    Route::resource('type-of-cars', 'TypeOfCarController');

    // Car Colors
    Route::delete('car-colors/destroy', 'CarColorController@massDestroy')->name('car-colors.massDestroy');
    Route::resource('car-colors', 'CarColorController');

    // Car Lists
    Route::delete('car-lists/destroy', 'CarListController@massDestroy')->name('car-lists.massDestroy');
    Route::resource('car-lists', 'CarListController');


    // Expense Category
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Category
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Income
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Report
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');



    Route::resource('reports', 'ReportController');

    // Sliders
    Route::delete('sliders/destroy', 'SliderController@massDestroy')->name('sliders.massDestroy');
    Route::resource('sliders', 'SliderController');

    // Top Restaurants
    Route::delete('top-restaurants/destroy', 'TopRestaurantsController@massDestroy')->name('top-restaurants.massDestroy');
    Route::resource('top-restaurants', 'TopRestaurantsController');

    // Category Top Restaurants
    Route::delete('category-top-restaurants/destroy', 'CategoryTopRestaurantsController@massDestroy')->name('category-top-restaurants.massDestroy');
    Route::resource('category-top-restaurants', 'CategoryTopRestaurantsController');

    // Venture Companies
    Route::delete('venture-companies/destroy', 'VentureCompaniesController@massDestroy')->name('venture-companies.massDestroy');
    Route::resource('venture-companies', 'VentureCompaniesController');

    // Become Partners
    Route::delete('become-partners/destroy', 'BecomePartnerController@massDestroy')->name('become-partners.massDestroy');
    Route::resource('become-partners', 'BecomePartnerController');

    // Sms History
    Route::delete('sms-histories/destroy', 'SmsHistoryController@massDestroy')->name('sms-histories.massDestroy');
    Route::resource('sms-histories', 'SmsHistoryController');

    // Loopuser
    Route::delete('loopusers/destroy', 'LoopuserController@massDestroy')->name('loopusers.massDestroy');
    Route::resource('loopusers', 'LoopuserController');
    Route::get('loopusers/{id}/active', 'LoopuserController@active')->name('loopusers.active');

    // Loop Bank
    Route::delete('loop-banks/destroy', 'LoopBankController@massDestroy')->name('loop-banks.massDestroy');
    Route::resource('loop-banks', 'LoopBankController');

    // Referral Subscription
    Route::delete('referral-subscriptions/destroy', 'ReferralSubscriptionController@massDestroy')->name('referral-subscriptions.massDestroy');
    Route::resource('referral-subscriptions', 'ReferralSubscriptionController');



});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
