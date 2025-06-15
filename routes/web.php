<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

use App\Http\Controllers\{
    AdminController,
    AuthController,
    CartController,
    CheckoutController,
    HomeController,
    ProductController,
    UserController
};

// Import middleware langsung (untuk FQCN)
use App\Http\Middleware\UserAccess;
use App\Http\Middleware\AddCspHeader;

// =====================
// ⛳ Halaman Utama
// =====================
Route::view('/', 'landing_page');

// =====================
// 👤 Guest Only
// =====================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginProces'])->name('loginProces');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerProcess'])->name('registerProcess');
});

// =====================
// 🔐 Authenticated
// =====================
Route::middleware('auth')->group(function () {

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // =======================
    // 🛠 Admin Only
    // =======================
    Route::middleware(UserAccess::class . ':admin')->group(function () {
        Route::get('/AdminMenu', [AdminController::class, 'admin']);
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Produk
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/admin/products', [ProductController::class, 'paginate'])->name('admin.products.paginate');

        // Transaksi
        Route::get('/admin/transaksi', [CheckoutController::class, 'index'])->name('admin.transaksi');

        // Orders
        Route::get('/orders', [App\Http\Controllers\Admin\OrderStatusController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}/edit', [App\Http\Controllers\Admin\OrderStatusController::class, 'edit'])->name('admin.orders.edit');
        Route::put('/orders/{order}', [App\Http\Controllers\Admin\OrderStatusController::class, 'update'])->name('admin.orders.update');
    });

    // =======================
    // 👤 User Only
    // =======================
    Route::get('/home', [AdminController::class, 'user'])->middleware(UserAccess::class . ':user');
    Route::get('/userDashboard', [UserController::class, 'dashboard'])->name('userDashboard');

    // Profil
    Route::put('/profil', [UserController::class, 'update'])->name('profil.update');

    // =======================
    // 🛒 Cart
    // =======================
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'viewCart'])->name('cart.index');
        Route::post('/{product}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::patch('/updateQuantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    });

    // =======================
    // 🧾 Checkout
    // =======================
    Route::middleware(AddCspHeader::class)->group(function () {
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::delete('/checkout', [CheckoutController::class, 'destroy'])->name('checkout.destroy');
    });

    // Order history
    Route::get('/orders/history', [CheckoutController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
});

// =====================
// 🌐 Public
// =====================
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'index'])->name('products.search');
Route::get('/products/category/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::view('/aboutUs', 'aboutUs')->name('aboutUs');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// =====================
// 🔐 Google Auth
// =====================
Route::get('/auth/google', fn () => Socialite::driver('google')->redirect());
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
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
