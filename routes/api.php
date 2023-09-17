<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FrontEndController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['api', 'checkPassword']], function () {
    Route::group(['prefix' => 'frontend'], function () {
        Route::post('/getHomePageData', [FrontEndController::class, 'getHomePageData']);
        Route::post('/shop', [FrontEndController::class, 'shop']);
        Route::post('/getproductDetails', [FrontEndController::class, 'getproductDetails']);
        Route::post('/getAttribute', [FrontEndController::class, 'getAttribute']);
        Route::post('/aboutUsData', [FrontEndController::class, 'aboutUsData']);
        Route::post('/privacyPolicyData', [FrontEndController::class, 'privacyPolicyData']);
        Route::post('/faqsData', [FrontEndController::class, 'faqsData']);
        Route::post('/getContactUsData', [FrontEndController::class, 'getContactUsData']);
        Route::post('/requistContactUsData', [FrontEndController::class, 'requistContactUsData']);
        Route::post('/getProductByCategory', [FrontEndController::class, 'getProductByCategory']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('/login', [CustomerController::class, 'login']);
        Route::post('/register', [CustomerController::class, 'register']);

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('/addToCart', [CustomerController::class, 'addToCart']);
            Route::post('/getCart', [CustomerController::class, 'getCart']);
            Route::post('/updateCart', [CustomerController::class, 'updateCart']);
            Route::post('/checkout', [CustomerController::class, 'checkout']);
            Route::post('/getAddress', [CustomerController::class, 'getAddress']);
            Route::post('/addAddress', [CustomerController::class, 'addAddress']);
            Route::post('/checkoutData', [CustomerController::class, 'checkoutData']);
            Route::post('/deleteAddress', [CustomerController::class, 'deleteAddress']);
            Route::post('/updatePassword', [CustomerController::class, 'updatePassword']);
            Route::post('/logout', [CustomerController::class, 'logout']);
            Route::post('/deleteUserAccount', [CustomerController::class, 'deleteUserAccount']);
            Route::post('/getWishlist', [CustomerController::class, 'getWishlist']);
            Route::post('/addWishlist', [CustomerController::class, 'addWishlist']);
            Route::post('/getOrders', [CustomerController::class, 'getOrders']);
        });
    });

});
