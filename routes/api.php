<?php

use App\Http\Controllers\AccountInformationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogNavigationController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MyVehicleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleSearchController;
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
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/reset-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::get('/product-categories/{locale}', [CatalogNavigationController::class, 'getProductCategories']);
Route::get('/category-products/{locale}/{page_id}', [ProductController::class, 'getCategoryProductsAPI'])
    ->whereAlpha('locale')
    ->whereNumber('page_id');

Route::post('/customer-login', [AuthController::class, 'customerLogin']);
Route::post('/customer-register', [AuthController::class, 'customerRegister']);
Route::post('/customer-remind-password', [AuthController::class, 'customerRemindPassword']);
Route::post('/customer-reset-password', [AuthController::class, 'customerResetPassword']);

Route::get('/vehicle-search/{brand_id}/{year_from}/{year_to}', [VehicleSearchController::class, 'search']);
Route::post('/active-vehicle', [VehicleSearchController::class, 'activeVehicle']);

Route::post('/send-message', [ContactFormController::class, 'sendMessage']);

Route::group(['prefix' => '/subscriptions'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/', [SubscribeController::class, 'subscriptions']);
        Route::post('/save', [SubscribeController::class, 'saveSubscriptions']);
    });
});

Route::group(['prefix' => '/account-information'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/', [AccountInformationController::class, 'accountInformation']);
        Route::post('/save', [AccountInformationController::class, 'saveAccountInformation']);
        Route::post('/change-password', [AccountInformationController::class, 'changePassword']);
    });
});

Route::group(['prefix' => '/downloads'], function () {
    Route::get('/get/{locale}/{page_id}', [ProductController::class, 'getDownloadFiles'])
        ->whereAlpha('locale')
        ->whereNumber('page_id');
});

Route::group(['prefix' => '/auth'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/user/change-theme', [AuthController::class, 'changeTheme']);
        Route::post('/user/toggle-sidebar', [AuthController::class, 'toggleSidebar']);

        Route::get('/users', [UserController::class, 'users']);
        Route::get('/users/{id}', [UserController::class, 'user']);

        Route::get('/roles', [RoleController::class, 'roles']);
        Route::post('/roles/save-permission', [RoleController::class, 'savePermission']);
        Route::post('/roles/save-role', [RoleController::class, 'saveRole']);
        Route::delete('/roles/delete/{id}', [RoleController::class, 'deleteRole']);
        Route::get('/roles/{id}', [RoleController::class, 'role']);

        Route::get('/pages/page/{type?}/{page_id?}/{language_id?}', [PageController::class, 'getPage']);
        Route::post('/pages/save-page', [PageController::class, 'savePage']);
        Route::delete('/pages/delete/{id}', [PageController::class, 'deletePage']);
        Route::get('/pages/{type?}', [PageController::class, 'pages']);

        Route::get('/messages', [ContactFormController::class, 'messages']);
        Route::get('/subscribers', [SubscribeController::class, 'subscribers']);

        Route::get('/menus', [MenuController::class, 'menus']);
        Route::post('/menus/save', [MenuController::class, 'save']);
        Route::get('/menus/{id}', [MenuController::class, 'menu']);

        Route::get('/settings', [SettingsController::class, 'settings']);
        Route::post('/settings/toggle-maintenance', [SettingsController::class, 'toggleMaintenance']);
        Route::post('/settings/save-store-information', [SettingsController::class, 'saveStoreInformation']);

        Route::get('/settings/languages', [LanguagesController::class, 'languages']);
        Route::post('/settings/languages/save', [LanguagesController::class, 'saveLanguage']);
        Route::get('/settings/languages/{id}', [LanguagesController::class, 'language']);


        Route::get('/logout', [AuthController::class, 'logout']);

        Route::get('/customer', [AuthController::class, 'customer']);
        Route::get('/customer-logout', [AuthController::class, 'customerLogout']);
    });
});

Route::group(['prefix' => '/my-vehicles'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/{locale}', [MyVehicleController::class, 'myVehicle']);
        Route::post('/add', [MyVehicleController::class, 'storeMyVehicle']);
        Route::post('/set-active', [MyVehicleController::class, 'setActiveMyVehicle']);
        Route::delete('/remove/{id}', [MyVehicleController::class, 'removeMyVehicle']);
    });
});

Route::group(['prefix' => '/cart'], function () {
    Route::get('/{locale}/{id}', [ProductController::class, 'getCart']);
    Route::post('/save', [ProductController::class, 'addToCart']);
    Route::post('/update', [ProductController::class, 'updateProductQuantity']);
    Route::delete('/remove/{locale}/{id}/{product_id}', [ProductController::class, 'removeFromCart']);
});

Route::group(['prefix' => '/product-comparison'], function () {
    Route::get('/{locale}/{id}', [ProductController::class, 'getCompareList']);
    Route::post('/save', [ProductController::class, 'addToCompare']);
    Route::delete('/remove/{id}', [ProductController::class, 'deleteProductCompare']);
    Route::delete('/remove/{locale}/{id}/{product_id}', [ProductController::class, 'removeProductFromProductCompare']);
});

Route::group(['prefix' => '/shop', 'middleware' => 'auth:api'], function () {
    Route::group(['prefix' => '/attributes'], function () {
        Route::get('/get', [ShopController::class, 'getAttributes']);
        Route::post('/save', [ShopController::class, 'createAttribute']);
        Route::get('/delete/{id}', [ShopController::class, 'deleteAttributes'])
            ->whereNumber('id');
        Route::get('/delete/value/{valueId}', [ShopController::class, 'deleteAttributeValue'])
            ->whereNumber('valueId');
        Route::post('/update/{id}', [ShopController::class, 'updateAttribute'])
            ->whereNumber('id');
    });

    Route::group(['prefix' => '/warehouses'], function () {
        Route::get('/get', [ShopController::class, 'getWarehouses']);
        Route::post('/create', [ShopController::class, 'createWarehouse']);
        Route::post('/update/{id}', [ShopController::class, 'updateWarehouse'])
            ->whereNumber('id');
        Route::get('/delete/{id}', [ShopController::class, 'deleteWarehouse'])
            ->whereNumber('id');

        Route::post('/create/group', [ShopController::class, 'createWarehouseGroup']);
        Route::post('/update/group/{id}', [ShopController::class, 'updateWarehouseGroup'])
            ->whereNumber('id');
        Route::get('/delete/group/{id}', [ShopController::class, 'deleteWarehouseGroup'])
            ->whereNumber('id');
    });
});

Route::group(['prefix' => '/page', 'middleware' => 'auth:api'], function () {
    Route::group(['prefix' => '/gallery'], function () {
        Route::get('/get/{page_id}', [ProductController::class, 'getGalleryImagesAPI'])
            ->whereNumber('page_id');
        Route::post('/create/{page_id}', [ProductController::class, 'createGalleryImage'])
            ->whereNumber('page_id');
        Route::post('/update/{page_id}', [ProductController::class, 'updateGalleryImages'])
            ->whereNumber('page_id');
        Route::get('/delete/{page_id}/{image_id}', [ProductController::class, 'deleteGalleryImage'])
            ->whereNumber('page_id')
            ->whereNumber('image_id');
    });

    Route::group(['prefix' => '/downloads'], function () {
        Route::get('/get/{language_id}/{page_id}', [ProductController::class, 'getDownloadFilesAPI'])
            ->whereNumber('language_id')
            ->whereNumber('page_id');
        Route::post('/create/{page_id}', [ProductController::class, 'createDownloadFile'])
            ->whereNumber('language_id')
            ->whereNumber('page_id');
        Route::post('/update/{language_id}/{page_id}', [ProductController::class, 'updateDownloadFiles'])
            ->whereNumber('language_id')
            ->whereNumber('page_id');
        Route::get('/delete/{page_id}/{id}', [ProductController::class, 'deleteDownloadFile'])
            ->whereNumber('id');
    });

    Route::group(['prefix' => '/products'], function () {
        Route::get('/get/{language_id}/{page_id}', [ProductController::class, 'getProducts'])
            ->whereNumber('language_id')
            ->whereNumber('page_id');
    });

    Route::group(['prefix' => '/relations'], function () {
        Route::get('/get/{page_id}/{language_id}/{type}', [ProductController::class, 'getProductRelations'])
            ->whereNumber('page_id');
        Route::post('/create/{page_id}', [ProductController::class, 'createProductRelation'])
            ->whereNumber('page_id');
        Route::get('/delete/{page_id}/{related_product_id}', [ProductController::class, 'deleteProductRelation'])
            ->whereNumber('id')
            ->whereNumber('related_product_id');
    });
});
