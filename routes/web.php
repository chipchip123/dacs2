<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ReviewController;


// ------------------ HOME ------------------
Route::get('/', [ClientController::class, 'index'])->name('home');


// ------------------ PRODUCT ------------------
Route::get('/products', [ProductClientController::class, 'product'])->name('product');
Route::get('/products/category/{category_id}', [ProductClientController::class, 'product'])
    ->name('products.byCategory');

// PUBLIC REVIEWS - Cho phép guest xem đánh giá
Route::get('/reviews/product/{productId}', [ReviewController::class, 'listByProduct'])->name('reviews.list');


// ------------------ AUTH ------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/')->with('success', 'Bạn đã đăng xuất!');
});


// ------------------ PROFILE ------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// ------------------ CART ------------------
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/cart/update-ajax', [CartController::class, 'updateAjax'])->name('cart.update.ajax');
Route::post('/cart/add-ajax', [CartController::class, 'addAjax'])->name('cart.add.ajax');


// ------------------ CHECKOUT ------------------
Route::middleware('auth')->group(function () {

    // Checkout hiển thị
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Xử lý đặt hàng
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('orders.detail');

    // Reviews - Protected (require auth)
    Route::get('/reviews/create/{productId}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/store/{productId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{reviewId}/delete', [ReviewController::class, 'delete'])->name('reviews.delete');
});


// ------------------ COUPON ------------------
Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon.apply');


// ------------------ PAYMENT QR ------------------
Route::get('/payment/qr', [PaymentController::class, 'qrPage'])->name('payment.qr');
Route::get('/payment/check/{code}', [PaymentController::class, 'checkPayment']);



// ------------------ TELEGRAM WEBHOOK ------------------


// QUÊN MẬT KHẨU
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// RESET PASSWORD
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');





/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCouponController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\AdminReviewController;
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {


    // PRODUCTS
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [ProductController::class, 'delete'])->name('delete');
    });

    // CATEGORIES
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
    });

    // ORDERS
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
        Route::post('/store', [AdminOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
    });

    // COUPONS
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [AdminCouponController::class, 'index'])->name('index');
        Route::get('/create', [AdminCouponController::class, 'create'])->name('create');
        Route::post('/store', [AdminCouponController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminCouponController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [AdminCouponController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [AdminCouponController::class, 'delete'])->name('delete');
    });

    // REVIEWS
    Route::prefix('reviews')->name('reviews.')->group(function () {

        Route::get('/', [AdminReviewController::class, 'index'])->name('index');

        // ADD OR UPDATE ADMIN RESPONSE
        Route::post('/{id}/response', [AdminReviewController::class, 'addResponse'])->name('response');

        // DELETE ADMIN RESPONSE
        Route::delete('/{id}/response', [AdminReviewController::class, 'deleteResponse'])->name('response.delete');

        // DELETE REVIEW
        Route::delete('/{id}', [AdminReviewController::class, 'delete'])->name('delete');
    });


    // USERS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/send-mail-all', [AdminUserController::class, 'sendMailAll'])->name('sendMailAll');
        Route::post('/{id}/send-mail', [AdminUserController::class, 'sendMailOne'])->name('sendMailOne');
    });

    // STATISTICS
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

});


/*
|--------------------------------------------------------------------------
| BEAUTIFUL URL
|--------------------------------------------------------------------------
*/

Route::get('/san_pham', [ProductClientController::class, 'product'])->name('client.products');
Route::get('/san_pham/{category_id?}', [ProductClientController::class, 'product'])
    ->where('category_id', '[0-9]+')
    ->name('client.products.by_category');


Route::match(
    ['POST', 'GET'],
    '/webhook/telegram',
    [WebhookController::class, 'receive']
)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

