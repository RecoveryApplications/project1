<?php

use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Backend\Admin\FaqController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Admin\BrandController;
use App\Http\Controllers\Backend\Admin\OrderController;
use App\Http\Controllers\Backend\Admin\BannerController;
use App\Http\Controllers\Backend\Admin\PhotosController;
use App\Http\Controllers\Backend\Admin\SliderController;
use App\Http\Controllers\Backend\Admin\AboutUsController;
use App\Http\Controllers\Backend\Admin\ProductController;
use App\Http\Controllers\Backend\Admin\ReviewsController;
use App\Http\Controllers\Backend\Admin\ContactUsController;
use App\Http\Controllers\Backend\Admin\PromoCodeController;
use App\Http\Controllers\Backend\Admin\SizeColorController;
use App\Http\Controllers\Backend\Admin\NewsletterController;
use App\Http\Controllers\Backend\Admin\SubCategoryController;
use App\Http\Controllers\Backend\Admin\MainCategoryController;
use App\Http\Controllers\Backend\Admin\PrivacyPolicyController;
use App\Http\Controllers\Backend\Admin\SuperCategoryController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Backend\Admin\BlogsController;
use App\Http\Controllers\Backend\Admin\PaymentWalletsController;
use App\Http\Controllers\Backend\Admin\PublicValuesController;
use App\Http\Controllers\Backend\Admin\RequestedWalletOrders;
use App\Http\Controllers\Backend\Admin\SeoOperationsController;
use App\Http\Controllers\Backend\Admin\TermAndConditionController;
use App\Http\Controllers\Backend\Admin\WalletController;
use App\Http\Controllers\Frontend\WalletRequestOrdersController;
// ==================================================================================================================
// =========================================== Super Admin Routes ===================================================
// ==================================================================================================================

use Illuminate\Support\Facades\Route;

Route::prefix('super_admin')->name('super_admin.')->group(function () {

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');

    Route::group(['middleware' => 'auth:super_admin'], function () {
        // Dashboard Route :
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        // Support Tickets :
        // ==============================================================================
        Route::group(['prefix' => 'support_tickets'], function () {
            Route::get('/index', [SupportTicketController::class, 'index'])->name('support_tickets-index');
            Route::get('destroy/{id}', [SupportTicketController::class, 'destroy'])->name('support_tickets-destroy');
        });

        Route::group(['prefix' => 'newsletter'], function () {
            Route::get('/index', [NewsletterController::class, 'index'])->name('newsletter-index');
            Route::post('send-email', [NewsletterController::class, 'sendEmail'])->name('send-email');
        });



        // User Routes :
        // ==============================================================================
        Route::group(['prefix' => 'users'], function () {
            Route::get('/create', [UserController::class, 'create'])->name('users-create');
            Route::post('/store', [UserController::class, 'store'])->name('users-store');
            Route::get('/index', [UserController::class, 'index'])->name('users-index');
            Route::get('show/{id}/{user_type}', [UserController::class, 'show'])->name('users-show');
            Route::get('edit/{id}/{user_type}', [UserController::class, 'edit'])->name('users-edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('users-update');
            Route::get('/acceptSingle/{id}/{user_type}', [UserController::class, 'acceptSingle'])->name('users-acceptSingle');
            Route::get('/rejectSingle/{id}/{user_type}', [UserController::class, 'rejectSingle'])->name('users-rejectSingle');
            Route::get('/activeInactiveSingle/{id}/{user_type}', [UserController::class, 'activeInactiveSingle'])->name('users-activeInactiveSingle');
        });

        // Super Category Routes :
        // ==============================================================================
        Route::group(['prefix' => 'superCategories'], function () {
            Route::get('/create', [SuperCategoryController::class, 'create'])->name('superCategories-create');
            Route::post('/store', [SuperCategoryController::class, 'store'])->name('superCategories-store');
            Route::get('/index', [SuperCategoryController::class, 'index'])->name('superCategories-index');
            Route::get('show/{id}', [SuperCategoryController::class, 'show'])->name('superCategories-show');
            Route::get('edit/{id}', [SuperCategoryController::class, 'edit'])->name('superCategories-edit');
            Route::post('update/{id}', [SuperCategoryController::class, 'update'])->name('superCategories-update');
            Route::get('activeInactiveSingle/{id}', [SuperCategoryController::class, 'activeInactiveSingle'])->name('superCategories-activeInactiveSingle');
            Route::get('softDelete/{id}', [SuperCategoryController::class, 'softDelete'])->name('superCategories-softDelete');
            Route::get('showSoftDelete', [SuperCategoryController::class, 'showSoftDelete'])->name('superCategories-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [SuperCategoryController::class, 'softDeleteRestore'])->name('superCategories-softDeleteRestore');
            Route::get('destroy/{id}', [SuperCategoryController::class, 'destroy'])->name('superCategories-destroy');
        });

        // Main Category Routes :
        // ==============================================================================
        Route::group(['prefix' => 'mainCategories'], function () {
            Route::get('/create', [MainCategoryController::class, 'create'])->name('mainCategories-create');
            Route::post('/store', [MainCategoryController::class, 'store'])->name('mainCategories-store');
            Route::get('/index', [MainCategoryController::class, 'index'])->name('mainCategories-index');
            Route::get('show/{id}', [MainCategoryController::class, 'show'])->name('mainCategories-show');
            Route::get('edit/{id}', [MainCategoryController::class, 'edit'])->name('mainCategories-edit');
            Route::post('update/{id}', [MainCategoryController::class, 'update'])->name('mainCategories-update');
            Route::get('activeInactiveSingle/{id}', [MainCategoryController::class, 'activeInactiveSingle'])->name('mainCategories-activeInactiveSingle');
            Route::get('softDelete/{id}', [MainCategoryController::class, 'softDelete'])->name('mainCategories-softDelete');
            Route::get('showSoftDelete', [MainCategoryController::class, 'showSoftDelete'])->name('mainCategories-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [MainCategoryController::class, 'softDeleteRestore'])->name('mainCategories-softDeleteRestore');
            Route::get('destroy/{id}', [MainCategoryController::class, 'destroy'])->name('mainCategories-destroy');
        });

        // Super Category Routes :
        // ==============================================================================
        Route::group(['prefix' => 'subCategories'], function () {
            Route::get('/create', [SubCategoryController::class, 'create'])->name('subCategories-create');
            Route::post('/store', [SubCategoryController::class, 'store'])->name('subCategories-store');
            Route::get('/index', [SubCategoryController::class, 'index'])->name('subCategories-index');
            Route::get('show/{id}', [SubCategoryController::class, 'show'])->name('subCategories-show');
            Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('subCategories-edit');
            Route::post('update/{id}', [SubCategoryController::class, 'update'])->name('subCategories-update');
            Route::get('activeInactiveSingle/{id}', [SubCategoryController::class, 'activeInactiveSingle'])->name('subCategories-activeInactiveSingle');
            Route::get('softDelete/{id}', [SubCategoryController::class, 'softDelete'])->name('subCategories-softDelete');
            Route::get('showSoftDelete', [SubCategoryController::class, 'showSoftDelete'])->name('subCategories-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [SubCategoryController::class, 'softDeleteRestore'])->name('subCategories-softDeleteRestore');
            Route::get('destroy/{id}', [SubCategoryController::class, 'destroy'])->name('subCategories-destroy');

            Route::post('getMainCategories', [SubCategoryController::class, 'getMainCategories'])->name('getMainCategories');
        });

        // Wallet Routes :
        // ==============================================================================
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('/', [WalletController::class, 'index'])->name('wallet-index');
            Route::get('/pay-out/{id}', [WalletController::class, 'payOut'])->name('wallet-pay-out');
            // paymnet wallets
            Route::resource('payment_wallets', PaymentWalletsController::class);
            Route::post('payment_wallets/{id}/toggle-status', [PaymentWalletsController::class, 'toggleStatus'])->name('payment_wallets.toggle-status');
            // =========== Wallet Request Orders Controller ===========
            Route::get('requested_orders/{status?}', [RequestedWalletOrders::class, 'index'])->name('requested_orders.index');
            Route::post('requested_orders/pay/{id}', [RequestedWalletOrders::class, 'pay'])->name('requested_orders.pay');
            Route::post('requested_orders/reject/{id}', [RequestedWalletOrders::class, 'reject'])->name('requested_orders.reject');
        });



        // Product Routes :
        // ==============================================================================
        Route::group(['prefix' => 'products'], function () {
            Route::post('/updateItems', [ProductController::class, 'updateItems'])->name('update.items');
            Route::post('/importXlsxStore', [ProductController::class, 'importXlsxStore'])->name('products-importXlsxStore');
            Route::get('/importXlsx', [ProductController::class, 'importXlsx'])->name('products-importXlsx');
            Route::get('/create', [ProductController::class, 'create'])->name('products-create');
            Route::post('/store', [ProductController::class, 'store'])->name('products-store');
            Route::get('/index', [ProductController::class, 'index'])->name('products-index');
            Route::get('show/{id}', [ProductController::class, 'show'])->name('products-show');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products-edit');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('products-update');
            Route::get('activeInactiveSingle/{id}', [ProductController::class, 'activeInactiveSingle'])->name('products-activeInactiveSingle');
            Route::get('softDelete/{id}', [ProductController::class, 'softDelete'])->name('products-softDelete');
            Route::get('showSoftDelete', [ProductController::class, 'showSoftDelete'])->name('products-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [ProductController::class, 'softDeleteRestore'])->name('products-softDeleteRestore');
            Route::get('destroy/{id}', [ProductController::class, 'destroy'])->name('products-destroy');
            Route::post('addImages/{id}', [ProductController::class, 'AddImages'])->name('products-addImages');
            Route::get('deleteImages/{id}', [ProductController::class, 'deleteImages'])->name('products-deleteImages');
            Route::post('getSubCategories', [ProductController::class, 'getSubCategories'])->name('getSubCategories');
            Route::post('getBrand', [ProductController::class, 'getBrand'])->name('getBrand');
            Route::get('properties/{id}', [ProductController::class, 'properties'])->name('products-properties');
            Route::post('propertiesStore/{id}', [ProductController::class, 'propertiesStore'])->name('properties-store');
            Route::get('propertiesCreate/{id}', [ProductController::class, 'propertiesCreate'])->name('properties-create');
            Route::get('propertiesShowSoftDelete/{id}', [ProductController::class, 'propertiesShowSoftDelete'])->name('properties-showSoftDelete');
            Route::get('propertyEdit/{id}', [ProductController::class, 'propertyEdit'])->name('property-edit');
            Route::post('propertyUpdate/{id}', [ProductController::class, 'propertyUpdate'])->name('property-update');
            Route::get('propertyShow/{id}', [ProductController::class, 'propertyShow'])->name('property-show');
            Route::post('propertyAddImages/{id}', [ProductController::class, 'propertyAddImages'])->name('properties-addImages');
            Route::get('propertyDeleteImages/{id}', [ProductController::class, 'propertyDeleteImages'])->name('properties-deleteImages');

            Route::post('/htmlSearchProduct', [ProductController::class, 'searchProduct'])->name('htmlSearchProduct');
            Route::get('products-export', [ProductController::class, 'productsExport'])->name('products-export');
        });


        // Colors Routes :
        // ==============================================================================
        Route::group(['prefix' => 'colors'], function () {
            Route::get('/colorIndex', [SizeColorController::class, 'colorIndex'])->name('colors-index');
            Route::post('/colorStore', [SizeColorController::class, 'colorStore'])->name('color-store');
            Route::post('/colorUpdate', [SizeColorController::class, 'colorUpdate'])->name('color-update');
            Route::get('/colorDestroy/{id}', [SizeColorController::class, 'colorDestroy'])->name('color-destroy');
        });


        // Sizes Routes :
        // ==============================================================================
        Route::group(['prefix' => 'sizes'], function () {
            Route::get('/sizeIndex', [SizeColorController::class, 'sizeIndex'])->name('sizes-index');
            Route::post('/sizeStore', [SizeColorController::class, 'sizeStore'])->name('size-store');
            Route::post('/sizeUpdate', [SizeColorController::class, 'sizeUpdate'])->name('size-update');
            Route::get('/sizeDestroy/{id}', [SizeColorController::class, 'sizeDestroy'])->name('size-destroy');
        });
        //ReviewsRoutes
        // ==============================================================================
        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/destroy/{id}', [ReviewsController::class, 'destroy'])->name('reviews-destroy');
            Route::get('update/{id}', [ReviewsController::class, 'update'])->name('reviews-update');
            Route::get('/index', [ReviewsController::class, 'index'])->name('reviews-index');
        });

        // Brands Routes :
        // ==============================================================================
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/index', [BrandController::class, 'index'])->name('brands-index');
            Route::get('/create', [BrandController::class, 'create'])->name('brands-create');
            Route::post('/store', [BrandController::class, 'store'])->name('brands-store');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brands-edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brands-update');
            Route::get('/destroy/{id}', [BrandController::class, 'destroy'])->name('brands-destroy');
            Route::get('activeInactiveSingle/{id}', [BrandController::class, 'activeInactiveSingle'])->name('brands-activeInactiveSingle');

            Route::post('/htmlSearchBrand', [BrandController::class, 'searchBrand'])->name('htmlSearchBrand');
        });


        // Orders Routes :
        // ==============================================================================
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/index', [OrderController::class, 'index'])->name('orders-index');
            Route::get('show/{id}', [OrderController::class, 'show'])->name('orders-show');
            Route::get('sendToDelivery/{id}', [OrderController::class, 'sendToDelivery'])->name('orders-sendToDelivery');
            Route::post('add-track-number', [OrderController::class, 'shipstation'])->name('add-track-number');

            Route::get('orders-export', [OrderController::class, 'ordersExport'])->name('orders-export');

            Route::get('accept-order/{id}', [OrderController::class, 'acceptOrder'])->name('acceptOrder');
            Route::get('reject-order/{id}', [OrderController::class, 'rejectOrder'])->name('rejectOrder');
            Route::get('accept-delivery/{id}', [OrderController::class, 'acceptDelivery'])->name('acceptDelivery');
            Route::get('reject-delivery/{id}', [OrderController::class, 'rejectDelivery'])->name('rejectDelivery');
            Route::get('accept-payment/{id}', [OrderController::class, 'acceptPay'])->name('acceptPay');
            Route::get('reject-payment/{id}', [OrderController::class, 'rejectPay'])->name('rejectPay');
        });


        // About Us Routes :
        // ==============================================================================
        Route::group(['prefix' => 'about_us'], function () {
            Route::get('/index', [AboutUsController::class, 'index'])->name('about_us-index');
            Route::get('edit', [AboutUsController::class, 'edit'])->name('about_us-edit');
            Route::post('update', [AboutUsController::class, 'update'])->name('about_us-update');
        });

        // SEO operations
        // ==============================================================================
        Route::group(['prefix' => 'seo_operations'], function () {
            Route::get('/index', [SeoOperationsController::class, 'index'])->name('seo_operations-index');
            Route::get('edit/{id}', [SeoOperationsController::class, 'edit'])->name('seo_operations-edit');
            Route::post('update/{id}', [SeoOperationsController::class, 'update'])->name('seo_operations-update');
        });
        // Banner
        // ==============================================================================
        Route::group(['prefix' => 'banners'], function () {
            Route::get('/index', [BannerController::class, 'index'])->name('banners-index');
            Route::get('edit/{id}', [BannerController::class, 'edit'])->name('banners-edit');
            Route::post('update/{id}', [BannerController::class, 'update'])->name('banners-update');
            Route::get('/create', [BannerController::class, 'create'])->name('banners-create');
            Route::get('show/{id}', [BannerController::class, 'show'])->name('banners-show');
            Route::post('/store', [BannerController::class, 'store'])->name('banners-store');
            Route::get('/showSoftDelete', [BannerController::class, 'showSoftDelete'])->name('banners-showSoftDelete');
            Route::get('softDelete/{id}', [BannerController::class, 'softDelete'])->name('banners-softDelete');
            Route::get('softDeleteRestore/{id}', [BannerController::class, 'softDeleteRestore'])->name('banners-softDeleteRestore');
            Route::get('destroy/{id}', [BannerController::class, 'destroy'])->name('banners-destroy');
            Route::get('activeInactiveSingle/{id}', [BannerController::class, 'activeInactiveSingle'])->name('banners-activeInactiveSingle');
        });

        // Blogs
        // ==============================================================================
        Route::group(['prefix' => 'blogs'], function () {
            Route::get('/index', [BlogsController::class, 'index'])->name('blogs-index');
            Route::get('/create', [BlogsController::class, 'create'])->name('blogs-create');
            Route::post('/store', [BlogsController::class, 'store'])->name('blogs-store');
            Route::get('show/{id}', [BlogsController::class, 'show'])->name('blogs-show');
            Route::get('edit/{id}', [BlogsController::class, 'edit'])->name('blogs-edit');
            Route::post('update/{id}', [BlogsController::class, 'update'])->name('blogs-update');
            Route::get('softDelete/{id}', [BlogsController::class, 'softDelete'])->name('blogs-softDelete');
            Route::get('/showSoftDelete', [BlogsController::class, 'showSoftDelete'])->name('blogs-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [BlogsController::class, 'softDeleteRestore'])->name('blogs-softDeleteRestore');
            Route::get('destroy/{id}', [BlogsController::class, 'destroy'])->name('blogs-destroy');
            Route::get('activeInactiveSingle/{id}', [BlogsController::class, 'activeInactiveSingle'])->name('blogs-activeInactiveSingle');
        });

        Route::group(['prefix' => 'photos'], function () {
            Route::get('/index', [PhotosController::class, 'index'])->name('photos-index');
            Route::post('/store', [PhotosController::class, 'store'])->name('photos-store');
            Route::get('/destroy/{id}', [PhotosController::class, 'destroy'])->name('photos-destroy');
        });




        // Term And Conditions Routes:
        // ==============================================================================
        Route::group(['prefix' => 'term_and_conditions'], function () {
            Route::get('/index', [TermAndConditionController::class, 'index'])->name('term_and_conditions-index');
            Route::get('/create', [TermAndConditionController::class, 'create'])->name('term_and_conditions-create');
            Route::post('/store', [TermAndConditionController::class, 'store'])->name('term_and_conditions-store');
            Route::get('show/{id}', [TermAndConditionController::class, 'show'])->name('term_and_conditions-show');
            Route::get('edit/{id}', [TermAndConditionController::class, 'edit'])->name('term_and_conditions-edit');
            Route::post('update/{id}', [TermAndConditionController::class, 'update'])->name('term_and_conditions-update');
            Route::get('softDelete/{id}', [TermAndConditionController::class, 'softDelete'])->name('term_and_conditions-softDelete');
            Route::get('/showSoftDelete', [TermAndConditionController::class, 'showSoftDelete'])->name('term_and_conditions-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [TermAndConditionController::class, 'softDeleteRestore'])->name('term_and_conditions-softDeleteRestore');
        });

        // Privacy Policy Routes:
        // ==============================================================================
        Route::group(['prefix' => 'privacy_policies'], function () {
            Route::get('/index', [PrivacyPolicyController::class, 'index'])->name('privacy_policies-index');
            Route::get('/create', [PrivacyPolicyController::class, 'create'])->name('privacy_policies-create');
            Route::post('/store', [PrivacyPolicyController::class, 'store'])->name('privacy_policies-store');
            Route::get('show/{id}', [PrivacyPolicyController::class, 'show'])->name('privacy_policies-show');
            Route::get('edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('privacy_policies-edit');
            Route::post('update/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy_policies-update');
            Route::get('softDelete/{id}', [PrivacyPolicyController::class, 'softDelete'])->name('privacy_policies-softDelete');
            Route::get('/showSoftDelete', [PrivacyPolicyController::class, 'showSoftDelete'])->name('privacy_policies-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [PrivacyPolicyController::class, 'softDeleteRestore'])->name('privacy_policies-softDeleteRestore');
        });

        // FAQ Routes :
        // ==============================================================================
        Route::group(['prefix' => 'faqs'], function () {
            Route::get('/create', [FaqController::class, 'create'])->name('faqs-create');
            Route::post('/store', [FaqController::class, 'store'])->name('faqs-store');
            Route::get('/index', [FaqController::class, 'index'])->name('faqs-index');
            Route::get('show/{id}', [FaqController::class, 'show'])->name('faqs-show');
            Route::get('edit/{id}', [FaqController::class, 'edit'])->name('faqs-edit');
            Route::post('update/{id}', [FaqController::class, 'update'])->name('faqs-update');
            Route::get('activeInactiveSingle/{id}', [FaqController::class, 'activeInactiveSingle'])->name('faqs-activeInactiveSingle');
            Route::get('softDelete/{id}', [FaqController::class, 'softDelete'])->name('faqs-softDelete');
            Route::get('showSoftDelete', [FaqController::class, 'showSoftDelete'])->name('faqs-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [FaqController::class, 'softDeleteRestore'])->name('faqs-softDeleteRestore');
            Route::get('destroy/{id}', [FaqController::class, 'destroy'])->name('faqs-destroy');
        });

        // Contact Us Routes :
        // ==============================================================================
        Route::group(['prefix' => 'contact_us-store'], function () {
            Route::get('/index', [ContactUsController::class, 'index'])->name('contact_us-index');
            Route::get('edit', [ContactUsController::class, 'edit'])->name('contact_us-edit');
            Route::post('update', [ContactUsController::class, 'update'])->name('contact_us-update');

            //Contact Us Requests
            Route::get('/requests', [ContactUsController::class, 'requests'])->name('contact_us-requests');
            Route::get('showRequest/{id}', [ContactUsController::class, 'showRequest'])->name('contact_us-showrequest');
            Route::get('destroy/{id}', [ContactUsController::class, 'destroyRequest'])->name('contact_us-destroyrequest');
        });

        // Slider Routes :
        // ==============================================================================
        Route::group(['prefix' => 'sliders'], function () {
            Route::get('/create', [SliderController::class, 'create'])->name('sliders-create');
            Route::post('/store', [SliderController::class, 'store'])->name('sliders-store');
            Route::get('/index', [SliderController::class, 'index'])->name('sliders-index');
            Route::get('show/{id}', [SliderController::class, 'show'])->name('sliders-show');
            Route::get('edit/{id}', [SliderController::class, 'edit'])->name('sliders-edit');
            Route::post('update/{id}', [SliderController::class, 'update'])->name('sliders-update');
            Route::get('activeInactiveSingle/{id}', [SliderController::class, 'activeInactiveSingle'])->name('sliders-activeInactiveSingle');
            Route::get('softDelete/{id}', [SliderController::class, 'softDelete'])->name('sliders-softDelete');
            Route::get('showSoftDelete', [SliderController::class, 'showSoftDelete'])->name('sliders-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [SliderController::class, 'softDeleteRestore'])->name('sliders-softDeleteRestore');
            Route::get('destroy/{id}', [SliderController::class, 'destroy'])->name('sliders-destroy');
        });

        // Promo Code Routes :
        // ==============================================================================
        Route::group(['prefix' => 'promo_codes'], function () {
            Route::get('/create', [PromoCodeController::class, 'create'])->name('promo_codes-create');
            Route::post('/store', [PromoCodeController::class, 'store'])->name('promo_codes-store');
            Route::get('/index', [PromoCodeController::class, 'index'])->name('promo_codes-index');
            Route::get('show/{id}', [PromoCodeController::class, 'show'])->name('promo_codes-show');
            Route::get('edit/{id}', [PromoCodeController::class, 'edit'])->name('promo_codes-edit');
            Route::post('update/{id}', [PromoCodeController::class, 'update'])->name('promo_codes-update');
            Route::get('activeInactiveSingle/{id}', [PromoCodeController::class, 'activeInactiveSingle'])->name('promo_codes-activeInactiveSingle');
            Route::get('softDelete/{id}', [PromoCodeController::class, 'softDelete'])->name('promo_codes-softDelete');
            Route::get('showSoftDelete', [PromoCodeController::class, 'showSoftDelete'])->name('promo_codes-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [PromoCodeController::class, 'softDeleteRestore'])->name('promo_codes-softDeleteRestore');
            Route::get('destroy/{id}', [PromoCodeController::class, 'destroy'])->name('promo_codes-destroy');
        });

        // FAQ Routes :
        // ==============================================================================
        Route::group(['prefix' => 'public_values'], function () {
            Route::get('/create', [PublicValuesController::class, 'create'])->name('public_values-create');
            Route::post('/store', [PublicValuesController::class, 'store'])->name('public_values-store');
            Route::get('/index', [PublicValuesController::class, 'index'])->name('public_values-index');
            Route::get('show/{id}', [PublicValuesController::class, 'show'])->name('public_values-show');
            Route::get('edit/{id}', [PublicValuesController::class, 'edit'])->name('public_values-edit');
            Route::post('update/{id}', [PublicValuesController::class, 'update'])->name('public_values-update');
            Route::get('activeInactiveSingle/{id}', [PublicValuesController::class, 'activeInactiveSingle'])->name('public_values-activeInactiveSingle');
            Route::get('softDelete/{id}', [PublicValuesController::class, 'softDelete'])->name('public_values-softDelete');
            Route::get('showSoftDelete', [PublicValuesController::class, 'showSoftDelete'])->name('public_values-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [PublicValuesController::class, 'softDeleteRestore'])->name('public_values-softDeleteRestore');
            Route::get('destroy/{id}', [PublicValuesController::class, 'destroy'])->name('public_values-destroy');
        });
    });
});
