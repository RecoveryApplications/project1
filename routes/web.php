<?php

namespace App\Http\Controllers;

use App\Models\Faq;

// ===================================================================================================================
// ============================================ Start Used Controller Area ===========================================
// ===================================================================================================================
use App\Models\ContactUs;
use App\Models\PrivacyPolicy;
use App\Models\TermAndCondition;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontEndController;
use App\Http\Controllers\Backend\Admin\ReviewsController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\ProfileCustomerController;
use App\Http\Controllers\Frontend\BlogDetailsController;
use App\Http\Controllers\Frontend\BlogsController as blogController;
use App\Http\Controllers\Frontend\BlogsController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ShopController;
use App\Models\SeoOperation;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('/', function () {
//     return view('admin.index');
// });
// Route::get('/about', function () {
//     return view('admin.Blogs.index');
// });



Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::get('/compare', function () {
        return view('front_end_inners.compare');
    });

    Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

    // =======================================================================
    // ========================= Ajax Routes =================================
    // =======================================================================
    Route::post('/getItemDetails', [FrontEndController::class, 'getItemDetails'])->name('getItemDetails');
    Route::post('/getProductAttribute', [FrontEndController::class, 'getProductAttribute'])->name('getProductAttribute');
    Route::post('/getProductAttributeModal', [FrontEndController::class, 'getProductAttributeModal'])->name('getProductAttributeModal');
    // =======================================================================
    // ========================= Ajax Routes =================================
    // =======================================================================



    Route::get('/productList/{type?}/{id?}', [FrontEndController::class, 'productList'])->name('productList');
    Route::post('/productListPost/{type?}/{id?}', [FrontEndController::class, 'productListPost'])->name('productListPost');
    Route::get('/productDetails/{product_id}/{color?}/{size?}', [ProductController::class, 'view'])->name('productDetails');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/about-us', AboutUsController::class)->name('aboutUs');
    Route::get('/faqs', function () {
        $faqs = Faq::paginate(100);
        return view('front_end_inners.faqs', compact('faqs'));
    })->name('faqs');
    Route::get('/contact-us', function () {
        $contact_us = ContactUs::all()->first();
        $seo_operation = SeoOperation::where('page_name', 'Contact Us')->get()->first();
        return view('front_end_inners.contact')->with('seo_operation', $seo_operation)->with('contact_us', $contact_us);
    })->name('contactUs');
    Route::get('/Blogs', [BlogsController::class, 'index'])->name('Blogs');
    Route::get('/BlogDetails/{aliasname}', [BlogsController::class, 'view'])->name('BlogDetails');
    // Route::get('/BlogDetails/{aliasname}', [BlogDetailsController::class, 'BlogDetails'])->name('BlogDetails');

    Route::post('/contactUsRequest', [FrontEndController::class, 'contactUsRequest'])->name('contactUsRequest');

    Route::get('/privacy-policy', function () {
        $policy = PrivacyPolicy::get()->first();
        return view('policy', compact('policy'));
    })->name('policy');

    Route::get('/terms-conditions', function () {
        $terms = TermAndCondition::get()->first();
        return view('terms', compact('terms'));
    })->name('terms');


    // =======================================================================
    // ========================= Ahmad Routes =================================
    // =======================================================================
    Route::get('shop', [ShopController::class, 'index'])->name('shop');
    Route::get('shop-list', [ShopController::class, 'index2'])->name('shop-list');

    // ================================================================
    // ==================== Customer routes ===========================
    // ================================================================
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/loginRegister/{type?}', [CustomerController::class, 'loginRegister'])->name('loginRegister');
        Route::post('/login', [CustomerController::class, 'login'])->name('login');
        Route::get('/logout', [CustomerController::class, 'logout'])->name('logout');
        Route::post('/register', [CustomerController::class, 'register'])->name('register');


        Route::group(['middleware' => ['checkAuth']], function () {
            Route::get('/', [ProfileCustomerController::class, 'address'])->name('address');
            Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
            Route::post('/productReview', [CustomerController::class, 'productReview'])->name('productReview');
            Route::post('/addToCart', [CustomerController::class, 'addToCart'])->name('add-to-cart');
            Route::get('remove-from-cart/{id}', [CustomerController::class, 'removeItemFromCart'])->name('remove-from-cart');
            Route::post('/checkout', [CustomerController::class, 'checkout'])->name('checkout');

            Route::get('/wishlist/{id}', [CustomerController::class, 'wishlist'])->name('wishlist')->middleware('auth:customer');
            Route::get('/get-wish-list', [CustomerController::class, 'getWishList'])->name('getWishList')->middleware('auth:customer');
            Route::get('/checkoutPage', [CustomerController::class, 'checkoutPage'])->name('checkoutPage');
            Route::get('/orderOverview', [CheckoutController::class, 'index'])->name('orderOverview');
            Route::post('/orderOverview', [CheckoutController::class, 'store'])->name('orderOverview.store');


            Route::post('/deleteItemToCart', [FrontEndController::class, 'deleteItemToCart'])->name('deleteItemToCart');
            Route::get('/getCartPageAjax', [FrontEndController::class, 'getCartPageAjax'])->name('getCartPageAjax');
            Route::post('/updateCart', [CustomerController::class, 'updateCart'])->name('updateCart');
            Route::post('/checkpromoCode', [CartController::class, 'promoCode'])->name('checkpromoCode');
            Route::post('/addToCartAjax', [FrontEndController::class, 'addToCartAjax'])->name('addToCartAjax');
            Route::get('/getCartAjax', [FrontEndController::class, 'getCartAjax'])->name('getCartAjax');
            Route::post('/getOrderDetails', [CustomerController::class, 'getOrderDetails'])->name('getOrderDetails');
        });


        Route::group(['prefix' => 'reviews'], function () {
            Route::post('/store/{id}', [ReviewsController::class, 'store'])->name('reviews-store');
        });
    });
    // ================================================================
    // ==================== Customer routes ===========================
    // ================================================================
});




Route::group(['prefix' => 'account', 'middleware' => 'auth:customer'], function () {
    Route::post('update-img', [CustomerController::class, 'accountUpdateImg'])->name('account-update-img');
    Route::post('updateProfile/{id}', [ProfileCustomerController::class, 'updateProfile'])->name('customer-update.profile');
    Route::prefix('address')->group(function () {
        Route::get('/delete/{id}', [ProfileCustomerController::class, 'deleteAddress'])->name('address-destroy');
        Route::post('updateAddress/{id}', [ProfileCustomerController::class, 'updateAddress'])->name('updateAddress.profile');
    });
});
Route::post('createAddress', [ProfileCustomerController::class, 'createAddress'])->name('createAddress.profile');

require __DIR__ . '/super_admin.php';
