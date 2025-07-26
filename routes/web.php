<?php

use Illuminate\Support\Facades\Route;

// ================== Admin Controllers ==================
use App\Http\Controllers\Admin\{
    LoginController,
    DashboardController,
    ProductController as AdminProductController,
    CategoryController,
    MaterialController,
    SizeController,
    LaminationController,
    OrderController as AdminOrderController,
};

// ================== Pelanggan Controllers ==================
use App\Http\Controllers\Pelanggan\{
    HomeController,
    ProductController as UserProductController,
    OrderController as UserOrderController,
    KontakController,
    TentangController
};

// ================== Halaman Utama (Pelanggan) ==================

// 🏠 Beranda
Route::get('/', [HomeController::class, 'index'])->name('pelanggan.beranda');

// 📄 Halaman Statis
Route::get('/kontak', [KontakController::class, 'index'])->name('pelanggan.kontak');
Route::get('/tentang-kami', [TentangController::class, 'index'])->name('pelanggan.tentang');

// 📦 Detail Produk
Route::get('/products/{id}', [UserProductController::class, 'show'])->name('pelanggan.products.show');

// 📝 Pemesanan Produk
Route::post('/products/{product}/order', [UserOrderController::class, 'preStore'])->name('pelanggan.products.preorder');
// 📝 Pemesanan Produk Tahap 1 (preStore)
Route::post('/order/prestore', [UserOrderController::class, 'preStore'])->name('order.prestore');

// 💳 Tahap 2: Konfirmasi Pesanan
Route::get('/order/confirmation/{id}', [UserOrderController::class, 'showConfirmation'])->name('order.confirmation');
Route::post('/order/confirmation/{id}/finalize', [UserOrderController::class, 'finalize'])->name('order.finalize');

// 💳 Tahap 3: Upload Bukti Pembayaran
Route::get('/order/{id}/upload-payment', [UserOrderController::class, 'uploadPage'])->name('order.uploadPage');
Route::post('/order/{id}/upload-payment-proof', [UserOrderController::class, 'uploadPaymentProof'])->name('order.uploadPaymentProof');

// ✅ Halaman Sukses
Route::get('/order/{id}/success', [UserOrderController::class, 'successPage'])->name('order.successPage');

// ❌ Batalkan Pesanan
Route::delete('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');

// 🚚 Cek Ongkir
Route::post('/cek-ongkir', [UserOrderController::class, 'cekOngkir']);

Route::get('/get-provinces', [UserOrderController::class, 'getProvinces']);
Route::get('/get-cities/{province_id}', [UserOrderController::class, 'getCities']);

// ================== Admin Login / Logout ==================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================== Admin Panel (Protected) ==================
Route::middleware(['auth'])->group(function () {
    // 📊 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 📦 Produk
    Route::resource('/admin/products', AdminProductController::class)->names('admin.products');
   Route::delete('/admin/products/images/{id}', [AdminProductController::class, 'destroyImage'])->name('admin.products.images.destroy');


    // 📄 Pesanan
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    // Pesanan Baru
    Route::get('/admin/orders/new', [AdminOrderController::class, 'newOrders'])->name('admin.orders.new');

    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    
    Route::put('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/riwayat-pesan', [AdminOrderController::class, 'history'])->name('admin.orders.history');
});
