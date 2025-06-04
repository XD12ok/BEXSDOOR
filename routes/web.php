<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('landing_page');
});

// Routes untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginProces'])->name('loginProces');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerProcess'])->name('registerProcess');
});

// Routes untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Admin & user menu dan akses
    Route::get('/admin', [AdminController::class, 'redirect'])->name('admin.menu')->middleware('UserAccess:admin');

    Route::get('/AdminMenu', [AdminController::class, 'admin'])->middleware('UserAccess:admin');
    Route::get('/home', [AdminController::class, 'user'])->middleware('UserAccess:user');

    // Produk (admin only)
    Route::middleware('UserAccess:admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}/edit', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::middleware('UserAccess:admin')->group(function () {
        Route::get('/orders', [OrderStatusController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}/edit', [OrderStatusController::class, 'edit'])->name('admin.orders.edit');
        Route::put('/orders/{order}', [OrderStatusController::class, 'update'])->name('admin.orders.update');

        //pagination
        Route::get('/admin/products', [ProductController::class, 'paginate'])->name('admin.products.paginate');

        //dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/transaksi', [CheckoutController::class, 'index'])->name('admin.transaksi');
    });

    // Keranjang
    Route::post('/cart/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/updateQuantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

    // Checkout dengan middleware tambahan 'csp.sandbox'
    Route::middleware('csp.sandbox')->group(function () {
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::delete('/checkout', [CheckoutController::class, 'destroy'])->name('checkout.destroy');
    });

    // Order history
    Route::get('/orders/history', [CheckoutController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');

    //user dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('userdashboard');
    Route::put('/profil', [UserController::class, 'update'])->name('profil.update');

});

// Route yang bisa diakses tanpa login
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
//Route::post('/products/{id}', [ProductViewController::class, 'increment']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'index'])->name('products.search');
Route::get('/products/category/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');

//about us
Route::get('/aboutUs', function () {return view('aboutUs');})->name('aboutUs');

// Home untuk semua
Route::get('/home', [HomeController::class, 'index'])->name('home');

//google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect(); // jangan stateless di sini
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user(); // juga TANPA stateless

    $user = \App\Models\User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'password' => Hash::make(uniqid()),
            'role' => 'user',
        ]
    );

    Auth::login($user);
    return redirect('/home');
});
