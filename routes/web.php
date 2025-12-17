<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controller\HomeController;
use App\Http\Controller\Controller;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\SellerController; // อาจจะลืมเพิ่มบรรทัดนี้
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Admin\OrderManagementController;

use App\Http\Controllers\ReviewController;

use App\Http\Controllers\ShippingController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'indexs'])->name('users');
Route::get('/p_form', [App\Http\Controllers\HomeController::class, 'product_form'])->name('p_form');
Route::post('/p_form/p_insert', [App\Http\Controllers\HomeController::class, 'p_insert'])->name('product.insert');

Route::get('/product/edit/{id}', [App\Http\Controllers\HomeController::class, 'product_edit'])->name('product.edit');
Route::put('/product/update/{id}', [App\Http\Controllers\HomeController::class, 'product_update'])->name('product.update');

Route::delete('/product/delete/{id}', [App\Http\Controllers\HomeController::class, 'product_delete'])->name('product.delete');

Route::get('/p_detail/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('p_detail.show');
Route::get('/all-product', [App\Http\Controllers\HomeController::class, 'all_product'])->name('all-product');

// Routes สำหรับผู้ใช้ที่ login แล้ว
Route::middleware(['auth'])->group(function () {
    
    // ตะกร้าสินค้า
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/toggle-select/{id}', [CartController::class, 'toggleSelect'])->name('cart.toggleSelect');
    Route::post('/cart/select-all', [CartController::class, 'selectAll'])->name('cart.selectAll');
    Route::post('/cart/unselect-all', [CartController::class, 'unselectAll'])->name('cart.unselectAll');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');

    // ชำระเงิน
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('checkout.buyNow');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // คำสั่งซื้อ (เหมือนเดิม)
    Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/order/receipt/{id}', [OrderController::class, 'receipt'])->name('order.receipt');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/order/tracking/{id}', [OrderController::class, 'tracking'])->name('order.tracking');

    // สมัครเป็นผู้ขาย / สร้างร้าน
    Route::get('/seller/register', [SellerController::class, 'register'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    
    // Dashboard ผู้ขาย
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    
    // แก้ไขข้อมูลร้าน
    Route::get('/seller/shop/edit', [SellerController::class, 'editShop'])->name('seller.editShop');
    Route::put('/seller/shop/update', [SellerController::class, 'updateShop'])->name('seller.updateShop');
    
});

// Routes สำหรับผู้ขาย
Route::middleware(['auth'])->group(function () {
    // คำสั่งซื้อของร้าน
    Route::get('/seller/orders', [SellerOrderController::class, 'index'])->name('seller.orders');
    Route::get('/seller/orders/{id}', [SellerOrderController::class, 'show'])->name('seller.orders.show');
    Route::post('/seller/orders/{id}/status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.updateStatus');
    Route::post('/seller/orders/{id}/tracking', [SellerOrderController::class, 'updateTracking'])->name('seller.orders.updateTracking');

    Route::get('/seller/orders/{id}/confirm-delivery', [SellerOrderController::class, 'confirmDelivery'])->name('seller.orders.confirmDelivery');
    Route::post('/seller/orders/{id}/mark-delivered', [SellerOrderController::class, 'markAsDelivered'])->name('seller.orders.markDelivered');
});

// Routes สำหรับ Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/orders', [OrderManagementController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{id}', [OrderManagementController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('/orders/{id}/tracking', [OrderManagementController::class, 'updateTracking'])->name('admin.orders.updateTracking');
    Route::post('/orders/{id}/cancel', [OrderManagementController::class, 'cancel'])->name('admin.orders.cancel');
});


// routes/web.php
Route::post('/orders/{id}/cancel-request',[OrderController::class, 'cancelRequest'])->name('orders.cancel.request')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // รีวิวสินค้า
    Route::get('/product/{id}/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
});

Route::prefix('shipping')->group(function () {
    Route::get('/', [ShippingController::class, 'index'])->name('shipping.index');
    Route::post('/search', [ShippingController::class, 'search'])->name('shipping.search');
    Route::get('/detail', [ShippingController::class, 'index_detail'])->name('shipping.detail');
    // Fallback สำหรับ GET (ป้องกัน error)
    Route::get('/search', function() {
        return redirect()->route('shipping.detail')
            ->with('success', 'ส่งสินค้าสำเร็จ');
    });
    
    Route::post('/delivered/{id}', [ShippingController::class, 'markDelivered'])
        ->name('shipping.delivered');
});