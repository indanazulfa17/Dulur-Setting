<?php

use Illuminate\Support\Facades\Route;


// Admin Controllers
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

// Pelanggan Controllers
use App\Http\Controllers\Pelanggan\{
    HomeController,
    ProductController as UserProductController,
    OrderController as UserOrderController,
    KontakController,
    TentangController
};



// ================== Pelanggan Routes ==================
// 🏠 Beranda
Route::get('/', [HomeController::class, 'index'])->name('pelanggan.beranda');

// 📄 Halaman Statis
Route::get('/kontak', [KontakController::class, 'index'])->name('pelanggan.kontak');
Route::get('/tentang-kami', [TentangController::class, 'index'])->name('pelanggan.tentang');

// Produk (lihat daftar & detail produk)

Route::get('/products/{id}', [UserProductController::class, 'show'])->name('pelanggan.products.show');


// Pemesanan awal dari detail produk (POST untuk pre-store tanpa customer name & whatsapp)
Route::post('/products/{product}/order', [UserOrderController::class, 'preStore'])->name('pelanggan.products.preorder');
// Tahap 1: Simpan pesanan awal (draft)
Route::post('/order/prestore', [UserOrderController::class, 'preStore'])->name('order.prestore');

// Halaman konfirmasi untuk isi data customer, shipping, upload bukti pembayaran
Route::get('/order/confirmation/{id}', [UserOrderController::class, 'showConfirmation'])->name('order.confirmation');

// Finalisasi pesanan, update data customer dan status
Route::post('/order/confirmation/{id}/finalize', [UserOrderController::class, 'finalize'])->name('order.finalize');

// Halaman sukses setelah konfirmasi pesanan
Route::get('/order/{id}/success', [UserOrderController::class, 'successPage'])->name('order.success');

// Upload ulang bukti pembayaran (optional)
Route::post('/order/{id}/upload-payment-proof', [UserOrderController::class, 'uploadPaymentProof'])->name('order.uploadPaymentProof');


// ================== Login/Logout Admin ==================
// 🛡️ Login Admin
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ================== Admin Routes (auth) ==================

    
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/admin/riwayat-pesan', [AdminOrderController::class, 'history'])->name('admin.orders.history');
    Route::resource('/admin/products', AdminProductController::class)->names('admin.products');

    
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::middleware(['auth'])->group(function () {
});
