<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::prefix('admin/orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index'); // Hiển thị danh sách đơn hàng
        Route::get('/create', [OrderController::class, 'create'])->name('create'); // Hiển thị form tạo đơn hàng
        Route::post('/', [OrderController::class, 'store'])->name('store'); // Lưu đơn hàng mới
        Route::get('/{id}', [OrderController::class, 'show'])->name('show'); // Hiển thị chi tiết đơn hàng
        Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit'); // Hiển thị form sửa đơn hàng
        Route::put('/{id}', [OrderController::class, 'update'])->name('update'); // Cập nhật đơn hàng
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy'); // Xóa đơn hàng
    });
    // Các route khác mà bạn muốn bảo vệ

    // Routes cho Category
    Route::resource('categories', CategoryController::class);

    Route::resource('categories', CategoryController::class);
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('admin/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('admin/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

       // Các route cho quản lý đơn hàng
    Route::resource('orders', OrderController::class);


    // Routes cho User
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
    // Route::resource('users', UserController::class);


    // Route::get('admin/users', [UserController::class, 'index'])->name('users.index');
    // Route::get('admin/users/create', [UserController::class, 'create'])->name('users.create');
    // Route::post('admin/users', [UserController::class, 'store'])->name('users.store');
    // Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Route::put('admin/users/{id}', [UserController::class, 'update'])->name('users.update');
    // Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    // Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');


    Route::get('/home', function () {
        return view('welcome');
    });
    
    Route::get('/index', function () {
        return view('home');
    });
    
    Route::prefix('admin/orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index'); // Hiển thị danh sách đơn hàng
        Route::get('/create', [OrderController::class, 'create'])->name('create'); // Hiển thị form tạo đơn hàng
        Route::post('/', [OrderController::class, 'store'])->name('store'); // Lưu đơn hàng mới
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit'); // Hiển thị form chỉnh sửa đơn hàng
        Route::put('/{order}', [OrderController::class, 'update'])->name('update'); // Cập nhật đơn hàng
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy'); // Xóa đơn hàng
        Route::get('/{order}', [OrderController::class, 'show'])->name('show'); // Hiển thị chi tiết đơn hàng
    });
    
    
    Route::get('admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('admin/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('admin/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('admin/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('admin/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/add', [ProductController::class, 'create'])->name('addproducts');
    
    
    // Định nghĩa route cho trang hồ sơ
    Route::get('admin/profile', [ProfileController::class, 'show'])->name('profile');
    
    
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', function () {
        return view('welcome');
    });
    
     
    Route::get('/users', function () {
        return view('admin.users'); 
    })->name('users');
    Route::resource('users', UserController::class);
    //Route để xử lý đặt lại mật khẩu
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
    
    
    

    
    
});

    // Route cho đăng nhập
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    // Route cho đăng ký
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Route cho quên mật khẩu
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Route để hiển thị form gửi email quên mật khẩu
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    
    // Route để gửi email đặt lại mật khẩu
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    
    // Route để hiển thị form đặt lại mật khẩu
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    
    // Route để xử lý đặt lại mật khẩu
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
        ->name('password.update');









// Route::get('users', [UserController::class, 'index'])->name('cutomers');
// Route::get('users/add', [UserController::class, 'create'])->name('addusers');
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

