<?php

Route::get('/', 'LandingController');

//guest
Route::group(['middleware' => 'guest', 'namespace' => 'Guest'], function(){
    Route::get('/register', 'RegistrationController@showRegistrationForm');
    Route::post('/register', 'RegistrationController@doRegister');
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@doLogin');
});

Route::group(['prefix' => 'restaurant/{id}', 'middleware' => 'approved.restaurant'], function(){
    Route::get('/', 'ViewRestaurantController@overview')->name('restaurant.overview');
    Route::get('/menu', 'ViewRestaurantController@menu')->name('restaurant.menu');
    Route::get('/blog', 'ViewRestaurantController@blog')->name('restaurant.blog');
    Route::get('/cart', 'ViewRestaurantController@cart')->name('restaurant.cart')->middleware('auth');
    Route::get('/ads', 'ViewRestaurantController@ads')->name('restaurant.ads');
    Route::get('/photos', 'ViewRestaurantController@photos')->name('restaurant.photos');
    Route::get('/promos', 'ViewRestaurantController@promos')->name('restaurant.promos');
    Route::get('/reviews', 'ViewRestaurantController@reviews')->name('restaurant.reviews');
    Route::post('/reviews', 'ViewRestaurantController@saveReview')->name('restaurant.review.save');
});
    

Route::group(['middleware' => 'auth'], function(){
    Route::post('/logout', 'LogoutController');

    Route::get('/profile', 'ProfileController@showForm');
    Route::patch('/profile', 'ProfileController@doUpdate');
    

    Route::group(['prefix' => 'my-restaurant', 'namespace' => 'MyRestaurant'], function(){

        Route::post('/register', 'RegisterController');
        Route::get('/not-found', 'NotFoundController')->name('restaurant-not-found');

        Route::group(['middleware' => 'owner'], function(){
            Route::get('/', 'OverviewController@showForm');
            Route::patch('/', 'OverviewController@doSave');

            Route::get('/operating-hours', 'OperatingHoursController@showForm');
            Route::patch('/operating-hours', 'OperatingHoursController@doSave');
            
            Route::resource('menu', 'MenuController');
            Route::resource('photos', 'PhotosController');
            Route::resource('blog', 'BlogController');
            Route::resource('promos', 'PromosController');
            Route::resource('food-orders', 'OrdersController');
            Route::resource('advertisements', 'AdvertisementsController');

            Route::group(['prefix' => 'reports'], function(){
                Route::get('/order-status', 'ReportsController@orderStatus')->name('reports.order-status');
                Route::get('/top-sellers', 'ReportsController@topSellers')->name('reports.top-sellers');;
                Route::get('/daily-sales', 'ReportsController@dailySales')->name('reports.daily-sales');;
            });

        });
        
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
        Route::get('/', 'HomeController');
        Route::resource('categories', 'CategoriesController');
        Route::resource('users', 'UsersController');
        Route::resource('restaurants', 'RestaurantsController');
        Route::resource('menu-categories', 'MenuCategoriesController');
        Route::resource('restaurant-ads', 'RestaurantAdsController');
    });


    Route::patch('/clear/{status}', 'NotificationController@clear');
    Route::patch('/cancel-order/{orderId}', 'UserCancelOrderController');
    Route::resource('cart', 'CartController');
    Route::resource('orders', 'OrdersController');
});
