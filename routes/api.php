<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
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
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', [AuthController::class, 'getResetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post('/subscribe', [SubscribeController::class, 'subscribe']);

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

        Route::get('/subscribers', [SubscribeController::class, 'subscribers']);

        Route::get('/menus', [MenuController::class, 'menus']);
        Route::post('/menus/save', [MenuController::class, 'save']);
        Route::get('/menus/{id}', [MenuController::class, 'menu']);

        Route::get('/settings', [SettingsController::class, 'settings']);
        Route::post('/toggle-maintenance', [SettingsController::class, 'toggleMaintenance']);

        Route::get('/settings/languages', [LanguagesController::class, 'languages']);
        Route::post('/settings/languages/save', [LanguagesController::class, 'saveLanguage']);
        Route::get('/settings/languages/{id}', [LanguagesController::class, 'language']);


        Route::get('/logout', [AuthController::class, 'logout']);
    });
});
Route::middleware('web')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/increase', [CartController::class, 'increaseQuantity'])->name('cart.increase');
    Route::post('/cart/decrease', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');
    Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');


});
