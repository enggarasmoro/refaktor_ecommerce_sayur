<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->file(public_path('mobile-app.html'));
})->name('home');

// Keep mobile-app route for compatibility
Route::get('/mobile-app', function () {
    return response()->file(public_path('mobile-app.html'));
})->name('mobile.app');

// All banner/category/product JSON now strictly served via /api/v1/* (no alias)

// All API traffic must go through routes/api.php (/api/v1/*). No direct API routes here.

// One-off maintenance endpoint to clear caches (remove in production)
Route::get('/maintenance/flush-all', function(){
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return response()->json(['success'=>true,'message'=>'Caches cleared']);
});

// Admin routes to add test data
Route::get('/admin/add-test-banners', 'AdminController@addTestBanners')->name('admin.test.banners');
Route::get('/admin/add-test-categories', 'KategoriController@addTestKategori')->name('admin.test.categories');

Route::namespace('Auth')->group(function () {
    // Login Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    // Password Confirmation Routes...
    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');

    // Email Verification Routes...
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
});

// Old home routes - commented out for mobile app
// Route::get('/home', 'HomeController@index');
// Route::get('/home/getdataproduk/{kategori}', 'HomeController@getdataproduk');
// Route::get('/home/getkategori', 'HomeController@getkategori');
// Route::get('/', 'HomeController@index')->name('home');

// New Mobile App as Homepage
Route::get('/', function () {
    return response()->file(public_path('mobile-app.html'));
})->name('home');

// Keep old home functionality for API calls if needed
Route::get('/old-home', 'HomeController@index')->name('old.home');
Route::get('/home/getdataproduk/{kategori}', 'HomeController@getdataproduk');
Route::get('/home/getkategori', 'HomeController@getkategori');
Route::get('/myaccount', 'MyaccountController@index')->name('myaccount')->middleware('auth');
Route::post('/myaccount/editprofil', 'MyaccountController@editprofil')->name('myaccount.editprofil')->middleware('auth');
Route::get('/myaccount/detailorder/{id}', 'MyaccountController@detailorder')->name('myaccount.detailorder')->middleware('auth');
Route::get('/shop/{kategori?}', 'ShopController@index')->name('shop');
Route::post('/shop/addcart', 'ShopController@addcart')->name('shop.addcart');
Route::post('/shop/removecart', 'ShopController@removecart')->name('shop.removecart');
Route::get('/mycart', 'ShopController@mycart')->name('mycart');
Route::post('/shop/editqty', 'ShopController@editqty')->name('shop.editqty');
Route::get('/deletecart/{id}', 'ShopController@deletecart')->name('shop.deletecart');
Route::post('/addkupon', 'ShopController@check_kupon')->name('addkupon');
Route::get('/checkout', 'ShopController@checkout')->name('checkout');
Route::post('/addorder', 'ShopController@addorder')->name('addorder');
Route::post('/shop/search', 'ShopController@search')->name('shop.search');





Route::group(['prefix' => 'adminpanel', 'namespace' => 'Adminpanel'], function () {
    Route::get('login', 'LoginController@loginForm')->name('bo.login');
    Route::post('login', 'LoginController@login')->name('bo.signin');

    Route::group(['middleware' => 'admin'], function () {
    Route::get('/', 'HomeController@index')->name('bo.home');
    Route::get('dashboard', 'HomeController@index')->name('bo.dashboard');
        Route::get('logout', 'LoginController@logout')->name('bo.logout');

        // routes Master Admin
        Route::get('masteradmin', 'AdminController@index')->name('masteradmin');
        Route::post('masteradmin/getdata', 'AdminController@getdata')->name('masteradmin.getdata');
        Route::get('masteradmin/showmodal', 'AdminController@showmodal')->name('masteradmin.showmodal');
        Route::get('masteradmin/showmodaledit/{id}', 'AdminController@showmodaledit')->name('masteradmin.showmodaledit');
        Route::post('masteradmin/create', 'AdminController@create')->name('masteradmin.create');
        Route::post('masteradmin/edit', 'AdminController@edit')->name('masteradmin.edit');
        Route::get('masteradmin/delete/{id}', 'AdminController@delete')->name('masteradmin.delete');

        // routes Master Banner
        Route::get('masterbanner', 'BannerController@index')->name('masterbanner');
        Route::post('masterbanner/getdata', 'BannerController@getdata')->name('masterbanner.getdata');
        Route::get('masterbanner/showmodal', 'BannerController@showmodal')->name('masterbanner.showmodal');
        Route::get('masterbanner/showmodaledit/{id}', 'BannerController@showmodaledit')->name('masterbanner.showmodaledit');
        Route::post('masterbanner/create', 'BannerController@create')->name('masterbanner.create');
        Route::post('masterbanner/edit', 'BannerController@edit')->name('masterbanner.edit');
        Route::get('masterbanner/delete/{id}', 'BannerController@delete')->name('masterbanner.delete');

        // routes Master User
        Route::get('masteruser', 'UserController@index')->name('masteruser');
        Route::post('masteruser/getdata', 'UserController@getdata')->name('masteruser.getdata');
        Route::get('masteruser/showmodal', 'UserController@showmodal')->name('masteruser.showmodal');
        Route::get('masteruser/showmodaledit/{id}', 'UserController@showmodaledit')->name('masteruser.showmodaledit');
        Route::post('masteruser/create', 'UserController@create')->name('masteruser.create');
        Route::post('masteruser/edit', 'UserController@edit')->name('masteruser.edit');

        // routes Config Voucher
        Route::get('voucher', 'VoucherController@index')->name('configvoucher');
        Route::post('voucher/getdata', 'VoucherController@getdata')->name('configvoucher.getdata');
        Route::get('voucher/showmodal', 'VoucherController@showmodal')->name('configvoucher.showmodal');
        Route::get('voucher/showmodaledit/{id}', 'VoucherController@showmodaledit')->name('configvoucher.showmodaledit');
        Route::post('voucher/create', 'VoucherController@create')->name('configvoucher.create');
        Route::post('voucher/edit', 'VoucherController@edit')->name('configvoucher.edit');
        Route::get('voucher/delete/{id}', 'VoucherController@delete')->name('configvoucher.delete');

        // routes Config Bank
        Route::get('configbank', 'BankController@index')->name('configbank');
        Route::post('configbank/getdata', 'BankController@getdata')->name('configbank.getdata');
        Route::get('configbank/showmodal', 'BankController@showmodal')->name('configbank.showmodal');
        Route::get('configbank/showmodaledit/{id}', 'BankController@showmodaledit')->name('configbank.showmodaledit');
        Route::post('configbank/create', 'BankController@create')->name('configbank.create');
        Route::post('configbank/edit', 'BankController@edit')->name('configbank.edit');
        Route::get('configbank/delete/{id}', 'BankController@delete')->name('configbank.delete');

        // routes Produk Kategori
        Route::get('produkkategori', 'KategoriController@index')->name('produkkategori');
        Route::post('produkkategori/getdata', 'KategoriController@getdata')->name('produkkategori.getdata');
        Route::get('produkkategori/showmodal', 'KategoriController@showmodal')->name('produkkategori.showmodal');
        Route::get('produkkategori/showmodaledit/{id}', 'KategoriController@showmodaledit')->name('produkkategori.showmodaledit');
        Route::post('produkkategori/create', 'KategoriController@create')->name('produkkategori.create');
        Route::post('produkkategori/edit', 'KategoriController@edit')->name('produkkategori.edit');
        Route::get('produkkategori/delete/{id}', 'KategoriController@delete')->name('produkkategori.delete');

        // routes Produk
        Route::get('produk', 'ProdukController@index')->name('produk');
        Route::post('produk/getdata', 'ProdukController@getdata')->name('produk.getdata');
        Route::get('produk/showmodal', 'ProdukController@showmodal')->name('produk.showmodal');
        Route::get('produk/showmodaledit/{id}', 'ProdukController@showmodaledit')->name('produk.showmodaledit');
        Route::post('produk/create', 'ProdukController@create')->name('produk.create');
        Route::post('produk/edit', 'ProdukController@edit')->name('produk.edit');
        Route::get('produk/delete/{id}', 'ProdukController@delete')->name('produk.delete');


        // routes Master Jam Kirim
        Route::get('jamkirim', 'JamkirimController@index')->name('jamkirim');
        Route::post('jamkirim/getdata', 'JamkirimController@getdata')->name('jamkirim.getdata');
        Route::get('jamkirim/showmodal', 'JamkirimController@showmodal')->name('jamkirim.showmodal');
        Route::get('jamkirim/showmodaledit/{id}', 'JamkirimController@showmodaledit')->name('jamkirim.showmodaledit');
        Route::post('jamkirim/create', 'JamkirimController@create')->name('jamkirim.create');
        Route::post('jamkirim/edit', 'JamkirimController@edit')->name('jamkirim.edit');
        Route::get('jamkirim/delete/{id}', 'JamkirimController@delete')->name('jamkirim.delete');

        // routes Master Ongkos Kirim
        Route::get('ongkir', 'OngkirController@index')->name('ongkir');
        Route::post('ongkir/getdata', 'OngkirController@getdata')->name('ongkir.getdata');
        Route::get('ongkir/showmodal', 'OngkirController@showmodal')->name('ongkir.showmodal');
        Route::get('ongkir/showmodaledit/{id}', 'OngkirController@showmodaledit')->name('ongkir.showmodaledit');
        Route::post('ongkir/create', 'OngkirController@create')->name('ongkir.create');
        Route::post('ongkir/edit', 'OngkirController@edit')->name('ongkir.edit');
        Route::get('ongkir/delete/{id}', 'OngkirController@delete')->name('ongkir.delete');

         // routes order
         Route::get('order', 'OrderController@index')->name('order');
         Route::get('order/getdata/{id}', 'OrderController@getdata')->name('order.getdata');
         Route::get('order/showmodalview/{id}', 'OrderController@showmodalview')->name('order.showmodalview');
         Route::get('order/invoice/{id}', 'OrderController@showinvoice')->name('order.showinvoice');
         Route::get('order/confirmorder/{id}', 'OrderController@confirmorder')->name('order.confirmorder');
         Route::get('order/cancelorder/{id}', 'OrderController@cancelorder')->name('order.cancelorder');
         Route::get('order/completeorder/{id}', 'OrderController@completeorder')->name('order.completeorder');
         Route::get('order/showmodaledit/{id}', 'OrderController@showmodaledit')->name('order.showmodaledit');
         Route::post('order/editqty', 'OrderController@editqty')->name('order.editqty');
         Route::post('order/remove', 'OrderController@remove')->name('order.remove');
         Route::post('order/addproduk', 'OrderController@addproduk')->name('order.addproduk');
         Route::get('order/exportlaporan/{date?}', 'OrderController@exportlaporan')->name('order.exportlaporan');
         Route::get('order/onhold/{id}', 'OrderController@onhold')->name('order.onhold');
         Route::get('order/onholdfromcancel/{id}', 'OrderController@onholdfromcancel')->name('order.onholdfromcancel');
         Route::post('order/editorder', 'OrderController@editorder')->name('order.editorder');

         // routes Master Newslatter
        Route::get('masternewslatter', 'NewslatterController@index')->name('masternewslatter');
        Route::post('masternewslatter/getdata', 'NewslatterController@getdata')->name('masternewslatter.getdata');
        Route::get('masternewslatter/showmodal', 'NewslatterController@showmodal')->name('masternewslatter.showmodal');
        Route::get('masternewslatter/showmodaledit/{id}', 'NewslatterController@showmodaledit')->name('masternewslatter.showmodaledit');
        Route::post('masternewslatter/create', 'NewslatterController@create')->name('masternewslatter.create');
        Route::post('masternewslatter/edit', 'NewslatterController@edit')->name('masternewslatter.edit');
        Route::get('masternewslatter/delete/{id}', 'NewslatterController@delete')->name('masternewslatter.delete');
    });
});

//Clear Config cache:
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

