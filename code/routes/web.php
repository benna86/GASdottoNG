<?php

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(array('prefix' => 'api/1'), function () {
    Route::get('users/search', 'REST\UsersController@search');
    Route::resource('users', 'REST\UsersController');
    Route::resource('suppliers', 'REST\SuppliersController');
    Route::resource('products', 'REST\ProductsController');
});

Route::get('/', function () {
    return Redirect::to('/dashboard');
});

Route::get('/home', function () {
    return Redirect::to('/dashboard');
});

Route::get(substr(env('APP_KEY'), -5) . '/logs', '\MadBob\LaravelLog2Rss\Log2RssController@index');

Route::get('dashboard', 'CommonsController@getIndex');
Route::post('dashboard/verify', 'CommonsController@postVerify');

Route::get('gas/{id}/header', 'GasController@objhead');
Route::get('gas/{id}/logo', 'GasController@getLogo');
Route::get('gas/configmail', 'GasController@configureMail');

Route::get('users/ro/{id}', 'UsersController@show_ro');
Route::get('users/{id}/header', 'UsersController@objhead');
Route::get('users/search', 'UsersController@search');
Route::get('users/profile', 'UsersController@profile');
Route::get('users/picture/{id}', 'UsersController@picture');

Route::get('roles/{id}/header', 'RolesController@objhead');
Route::get('roles/user/{user_id}', 'RolesController@formByUser');
Route::get('roles/supplier/{supplier_id}', 'RolesController@formBySupplier');
Route::post('roles/attach', 'RolesController@attach');
Route::post('roles/detach', 'RolesController@detach');

Route::get('suppliers/ro/{id}', 'SuppliersController@show_ro');
Route::get('suppliers/{id}/header', 'SuppliersController@objhead');
Route::get('suppliers/catalogue/{id}/{format}', 'SuppliersController@catalogue');
Route::get('suppliers/{id}/products', 'SuppliersController@productsDetails');
Route::get('suppliers/{id}/products_grid', 'SuppliersController@productsGrid');
Route::get('suppliers/{id}/plain_balance', 'SuppliersController@plainBalance');

Route::get('products/ro/{id}', 'ProductsController@show_ro');
Route::get('products/{id}/header', 'ProductsController@objhead');
Route::post('products/massiveupdate', 'ProductsController@massiveUpdate');

Route::get('vatrates/{id}/header', 'VatRatesController@objhead');

Route::get('categories/{id}/header', 'CategoriesController@objhead');

Route::get('measures/{id}/header', 'MeasuresController@objhead');
Route::get('measures/list/{id}', 'MeasuresController@listProducts');

Route::get('variants/{id}/header', 'VariantsController@objhead');

Route::get('orders/{id}/header', 'OrdersController@objhead');
Route::get('orders/search', 'OrdersController@search');
Route::post('orders/recalculate/{id}', 'OrdersController@recalculate');
Route::get('orders/fixes/{id}/{product_id}', 'OrdersController@getFixes');
Route::post('orders/fixes/{id}', 'OrdersController@postFixes');
Route::get('orders/document/{id}/{type}', 'OrdersController@document');

Route::get('aggregates/{id}/header', 'AggregatesController@objhead');
Route::post('aggregates/notify/{id}', 'AggregatesController@notify');
Route::get('aggregates/document/{id}/{type}/{subtype?}', 'AggregatesController@document');

Route::get('attachments/{id}/header', 'AttachmentsController@objhead');
Route::get('attachments/download/{id}', 'AttachmentsController@download');

Route::get('bookings/{id}/header', 'BookingController@objhead');
Route::get('booking/{aggregate_id}/user/{user_id}/header', 'BookingUserController@objhead2');
Route::get('booking/{aggregate_id}/user/{user_id}/document', 'BookingUserController@document');
Route::get('booking/{id}/header', 'BookingController@objhead');

Route::get('deliveries/{id}/header', 'DeliveriesController@objhead');
Route::get('delivery/{aggregate_id}/user/{user_id}/header', 'DeliveryUserController@objhead2');
Route::get('deliveries/{aggregate_id}/fast', 'DeliveryUserController@getFastShipping');
Route::post('deliveries/{aggregate_id}/fast', 'DeliveryUserController@postFastShipping');

Route::get('notifications/{id}/header', 'NotificationsController@objhead');
Route::post('notifications/markread/{id}', 'NotificationsController@markread');

Route::get('movements/ro/{id}', 'MovementsController@show_ro');
Route::get('movements/{id}/header', 'MovementsController@objhead');
Route::get('movtypes/{id}/header', 'MovementTypesController@objhead');
Route::get('movements/showcredits', 'MovementsController@creditsTable');
Route::get('movements/balance', 'MovementsController@getBalance');
Route::post('movements/recalculate', 'MovementsController@recalculate');
Route::post('movements/close', 'MovementsController@closeBalance');
Route::get('movements/document/{type}/{subtype?}', 'MovementsController@document');

Route::post('import/csv', 'ImportController@postCsv');
Route::get('import/gdxp', 'ImportController@getGdxp');
Route::post('import/gdxp', 'ImportController@postGdxp');
Route::get('import/legacy', 'ImportController@getLegacy');
Route::post('import/legacy', 'ImportController@postLegacy');

Route::resource('gas', 'GasController');
Route::resource('users', 'UsersController');
Route::resource('roles', 'RolesController');
Route::resource('suppliers', 'SuppliersController');
Route::resource('products', 'ProductsController');
Route::resource('vatrates', 'VatRatesController');
Route::resource('deliveries', 'DeliveriesController');
Route::resource('categories', 'CategoriesController');
Route::resource('measures', 'MeasuresController');
Route::resource('variants', 'VariantsController');
Route::resource('orders', 'OrdersController');
Route::resource('aggregates', 'AggregatesController');
Route::resource('attachments', 'AttachmentsController');
Route::resource('booking.user', 'BookingUserController');
Route::resource('delivery.user', 'DeliveryUserController');
Route::resource('booking', 'BookingController');
Route::resource('bookings', 'BookingController');
Route::resource('notifications', 'NotificationsController');
Route::resource('movements', 'MovementsController');
Route::resource('movtypes', 'MovementTypesController');
Route::resource('stats', 'StatisticsController');
