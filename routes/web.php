<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RiwayatPenjualanController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\RiwayatOrderController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Staff\StaffProfileController;
use App\Http\Controllers\HomeController;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'Home']); //halaman home atau beranda

Route::controller(HomeController::class)->group(function(){

    Route::get('/shop' , 'ShopPage')->name('shop.page');
    Route::post('/shop/filter' , 'ShopFilter')->name('shop.filter');

   });


/*group routing untuk halaman login masing-masing user*/

//ADMIN
Route::get('/admin/login',[Admincontroller::class,'AdminLogin'])->middleware(RedirectIfAuthenticated::class);

//Staff
Route::get('/staff/login',[StaffProfileController::class,'StaffLogin'])->middleware(RedirectIfAuthenticated::class);

//customer
Route::get('/customer/login',[HomeController::class,'CustomerLogin'])->name('customer.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/customer/register',[HomeController::class,'CustomerRegistrasi'])->name('register.customer');
/* Routing Group pada bagian User Admin */


//bagian kelola profile
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/admin/dashboard',[AdminController::class,'AdminDashboard'])->name('admin.dashboard');

    Route::get('/review/product/admin',[AdminController::class,'showProductReview'])->name('review.admin');
    Route::get('/cetak-invoice/admin/{orderId}',[AdminController::class,'cetakInvoiceAdmin'])->name('cetakInvoiceAdmin');

    Route::get('/admin/profile',[AdminController::class,'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store',[AdminController::class,'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password',[AdminController::class,'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password',[AdminController::class,'AdminChangePassword'])->name('update.password');


    Route::get('/admin/logout',[AdminController::class,'AdminDestroy'])->name('admin.logout');
});


//Bagian Kelola Karyawan
Route::controller(KaryawanController::class)->group(function(){
    Route::get('/staff/all' , 'AllKaryawan')->name('staff.all');
    Route::get('/staff/tambah' , 'AddKaryawan')->name('staff.tambah');
    Route::post('/staff/store' , 'StoreKaryawan')->name('staff.store');
    Route::get('/staff/edit/{id}' , 'EditKaryawan')->name('staff.edit');
    Route::post('/staff/update' , 'UpdateKaryawan')->name('staff.update');
    Route::get('/staff/delete/{id}' , 'DeleteKaryawan')->name('staff.delete');

});

//lihat data customer
Route::get('/customer',[KaryawanController::class,'AllCustomer'])->name('customer.all');

//bagian kelola Produk
Route::controller(ProductController::class)->group(function(){

    Route::get('/admin/produk/all','AllProductAdmin')->name('produk.admin');

    Route::get('/admin/produk/tambah','AddProductAdmin')->name('tambah.product');
    Route::post('/admin/produk/store','ProductStoreAdmin')->name('store.product');

    Route::get('/admin/produk/edit/{product_id}','EditProductAdmin')->name('edit.product');
    Route::post('/admin/produk/update','UpdateProductAdmin')->name('update.product');

    Route::get('/admin/produk/delete/{product_id}','DeleteProductAdmin')->name('delete.product');
});


//Bagian Kelola Kategori produk
Route::controller(CategoryController::class)->group(function(){
    Route::get('/kategori/all/admin','AllCategoryAdmin')->name('category.admin');

    Route::get('/kategori/admin','AddCategoryAdmin')->name('tambah.kategori');
    Route::post('/kategori/store/admin','CategoryStoreAdmin')->name('store.kategori');

    Route::get('/admin/kategori/edit/{category_id}','EditCategoryAdmin')->name('category.edit');
    Route::post('/admin/kategori/update','UpdateCategoryAdmin')->name('category.update');


    Route::get('/admin/kategori/delete/{category_id}','DeleteCategoryAdmin')->name('category.delete');
});

//bagian riwayat penjualan
Route::get('/riwayat/penjualan/admin',[RiwayatPenjualanController::class,'HasilPenjualan'])->name('penjualan.admin');
Route::get('/laporan-penjualan',[RiwayatPenjualanController::class,'exportSales'])->name('laporan.penjualan');


//bagian menampilkan riwayat order customer



/*Akhir Routing Group pada bagian User Admin */

// Route::get('/cetak-invoice/staff/{orderId}','cetakInvoiceStaff')->name('cetakInvoiceStaff');

/*Routing Group pada bagian User Staff */

Route::middleware(['auth','role:staff'])->group(function(){
    Route::get('/staff/dashboard',[StaffProfileController::class,'StaffDashboard'])->name('staff.dashboard');

    Route::get('/review/product/',[StaffProfileController::class,'showProductReview'])->name('review.all');

    Route::get('/cetak-invoice/staff/{orderId}', [StaffProfileController::class, 'cetakInvoiceStaff'])
    ->name('cetakInvoiceStaff');

    Route::get('/staff/profile',[StaffProfileController::class,'StaffProfile'])->name('staff.profile');
    Route::post('/staff/profile/store',[StaffProfileController::class,'StaffProfileStore'])->name('staff.profile.store');


    Route::get('/staff/change/password',[StaffProfileController::class,'StaffChangedPassword'])->name('staff.change.password');
    Route::post('/staff/update/password',[StaffProfileController::class,'StaffUpdatePassword'])->name('staff.update.password');

    Route::get('/staff/logout',[StaffProfileController::class,'StaffDestroy'])->name('staff.logout');
});


//Bagian Kelola Kategori produk
Route::controller(CategoryController::class)->group(function(){
    Route::get('/kategori/all','AllCategory')->name('all.category');

    Route::get('/kategori/tambah','AddCategory')->name('tambah.category');
    Route::post('/kategori/store','CategoryStore')->name('store.category');

    Route::get('/kategori/edit/{category_id}','EditCategory')->name('kategori.edit');
    Route::post('/kategori/update','UpdateCategory')->name('kategori.update');


    Route::get('/kategori/delete/{category_id}','DeleteCategory')->name('kategori.delete');
});

//bagian kelola Produk
Route::controller(ProductController::class)->group(function(){

    Route::get('/produk/all','AllProduct')->name('all.produk');

    Route::get('/produk/tambah','AddProduct')->name('tambah.produk');
    Route::post('/produk/store','ProductStore')->name('store.produk');

    Route::get('/produk/edit/{product_id}','EditProduct')->name('edit.produk');
    Route::post('/produk/update','UpdateProduct')->name('update.produk');

    Route::get('/produk/delete/{product_id}','DeleteProduct')->name('delete.produk');
});

//bagian kelola kupon

Route::controller(CouponController::class)->group(function(){
    Route::get('/all/coupon' , 'AllCoupon')->name('all.coupon');

    Route::get('/add/coupon' , 'AddCoupon')->name('add.coupon');
    Route::post('/store/coupon' , 'StoreCoupon')->name('store.coupon');

    Route::get('/edit/coupon/{id}' , 'EditCoupon')->name('edit.coupon');
    Route::post('/update/coupon' , 'UpdateCoupon')->name('update.coupon');

    Route::get('/delete/coupon/{id}' , 'DeleteCoupon')->name('delete.coupon');

});


//melihat hasil penjualan
//bagian riwayat penjualan
Route::get('/riwayat/penjualan',[RiwayatPenjualanController::class,'HasilPenjualanStaff'])->name('penjualan.all');

/* Akhir Routing Group pada User Staff */


/*Group Routing User Customer */

Route::middleware(['auth','role:customer'])->group(function(){
    Route::get('/dashboard',[CustomerController::class,'CustomerDashboard'])->name('dashboard');

    Route::get('/customer/update/profile',[CustomerController::class,'updateCustomer'])->name('update.profile.customer');
    Route::post('/user/profile/store',[CustomerController::class,'CustomerProfileStore'])->name('update.profile.store');

    Route::get('/customer/ubah/password',[CustomerController::class,'CustomerUpdatePassword'])->name('customer.ubah.password');
    Route::post('/customer/update/password',[CustomerController::class,'UserUpdatePassword'])->name('user.update.password');

    Route::get('/user/logout',[CustomerController::class,'UserLogout'])->name('user.logout');

    //group Routing Wishlist Product
    Route::controller(WishlistController::class)->group(function(){
        Route::get('/wishlist' , 'AllWishlist')->name('wishlist');
        Route::get('/get-wishlist-product' , 'GetWishlistProduct');
        Route::get('/wishlist-remove/{id}' , 'WishlistRemove');
    });
});

//group routing pada Fitur Kupon product
Route::post('/coupon-apply',[CartController::class,'CouponApply']);
Route::get('/coupon-calculation',[CartController::class,'CouponCalculation']);
Route::get('/coupon-remove',[CartController::class,'CouponRemove']);


//group routing Cart product pada halaman beranda/home
Route::post('/cart/data/store/{id}',[CartController::class,'AddToCart']);

Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);

Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

Route::post('/dcart/data/store/{id}',[CartController::class,'AddToCartDetails']);

//group routing cart product
Route::controller(CartController::class)->group(function(){
    Route::get('/mycart','MyCart')->name('mycart');
    Route::get('/get-cart-product','GetCartProduct');
    Route::get('/cart-remove/{rowId}','CartRemove');

    Route::get('/cart-decrement/{rowId}','CartDecrement');
    Route::get('/cart-increment/{rowId}','CartIncrement');

});

Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

//group routing checkout
Route::controller(CheckoutController::class)->group(function(){
    Route::post('/calculate-shipping-cost','calculateShippingCost')->name('calculate.shipping.cost');
    Route::get('/province/ajax/{province_id}','ProvinceGetAjax');
    Route::get('/city/ajax/{regencies_id}','RegenciesGetAjax');
    Route::post('/checkout/store' , 'CheckoutStore')->name('checkout.store');
});

Route::controller(OrderController::class)->group(function(){
    Route::get('/order/product','orderCustomer')->name('order.customer');
    Route::post('/upload/pembayaran/{orderId}','uploadPaymentProof')->name('uploadPaymentProof');
    Route::get('/checkPaymentProof/{orderId}', 'checkPaymentProof')->name('checkPaymentProof');

    Route::get('/cetak-invoice/{orderId}','cetakInvoice')->name('cetakInvoice');

    //kelola order bagian staff
    Route::get('/order/pending/staff','pendingOrderStaff')->name('pending.staff');
    Route::get('/order/dikirim/staff','orderDikirimStaff')->name('dikirim.staff');
    Route::get('/order/selesai/staff','orderSelesaiStaff')->name('selesai.staff');
    Route::get('/order/batal/staff','orderCancelStaff')->name('batal.staff');

    Route::post('/update-order-status/staff','updateOrderStatusStaff')->name('updateStatusOrder.staff');
    Route::post('update-status-bayar/staff','updatePaymentStatusStaff')->name('updateStatusPayment.staff');

    //kelola order bagian user Admin
    Route::get('/order/dikirim/admin','orderDikirimAdmin')->name('dikirim.admin');
    Route::get('/order/pending/admin','pendingOrderAdmin')->name('pending.admin');
    Route::get('/order/selesai/admin','orderSelesaiAdmin')->name('selesai.admin');
    Route::get('/order/batal/admin','orderCancelAdmin')->name('batal.admin');


    Route::post('/update-order-status/admin','updateOrderStatusAdmin')->name('updateStatusOrder.admin');
    Route::post('update-status-bayar/admin','updatePaymentStatusAdmin')->name('updateStatusPayment.admin');
});


//Riwayat order user customer
Route::controller(RiwayatOrderController::class)->group(function(){
    Route::get('/riwayat/order/customer','RiwayatOrderCustomer')->name('detailOrder.customer');
    Route::post('/update-order-status', 'updateStatus');
    Route::post('/submit-review','StoreTestimoniProduk')->name('submit.review');
});
/*Akhir Group Routing pada user Customer */

/*Group Routing pada halaman awal */
// Route::get('/home',[HomeController::class,'Home'])->name('beranda');

//route pada fitur pencarian secara keseluruhan
Route::post('/search',[HomeController::class,'ProductSearch'])->name('product.search');

//route pada fitur pencarian data product secara detail
Route::post('/search-product',[HomeController::class,'SearchProduct']);

//route pencarian details product
Route::get('/product/details/{id}/{slug}',[HomeController::class,'ProductsDetails'])->name('product.details');

//route pencarian product berdasarkan categori
Route::get('/product/category/{id}/{slug}', [HomeController::class, 'CategoriProduct']);

//route add product kedalama Wishlist
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishList'])->middleware('auth');