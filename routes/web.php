<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ItemCategoryController;
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

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/dashboard',[HomeController::class, 'home'])->name('dashboard');
//     Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// });

// Route::group(['middleware' => 'auth', 'admin'], function () {
//     Route::get('/add-category', [CategoryController::class, 'index']);
//     Route::post('/post-add-karyawan', [KaryawanController::class, 'addKaryawan']);
//     Route::get('/delete-item/{id}', [ItemController::class, 'delete']);
//     Route::get('/update-karyawan-page/{id}', [KaryawanController::class, 'updateKaryawanPage']);
//     Route::patch('/update-karyawan/{id1}', [KaryawanController::class, 'updateKaryawan']);
// });

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[HomeController::Class, 'home'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('cart', [CartController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('update-cart/{id}', [CartController::class, 'update'])->name('update.cart');
    Route::delete('remove-from-cart/{id}', [CartController::class, 'remove'])->name('remove.from.cart');

    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/post-checkout', [CheckoutController::class, 'processCheckout'])->name('add.order');

    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order-detail/{id}', [OrderController::class, 'orderDetail'])->name('order.detail');
    Route::prefix('admin')->middleware(['isAdmin'])->group(function(){
        Route::controller(ItemController::class)->group(function(){
            Route::get('/add-item','addform')->name('add.item.form');
            Route::post('/post-add-item', 'create')->name('add.item');
            Route::get('/edit-item/{id}', 'editform')->name('edit.item.form');
            Route::patch('/post-edit-item/{id}', 'edit')->name('edit.item');
            Route::delete('/delete/{id}', 'deleteItem')->name('delete');
        });
        
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/add-category', 'addform')->name('add.cat.form');
            Route::post('/post-add-category', 'create')->name('add.cat');
        });
        
        Route::controller(ItemCategoryController::class)->group(function(){
            Route::get('/update-category/{id}','updateform')->name('update.cat.form');
            Route::post('/post-update-category/{id}', 'updatecategory')->name('update.cat');
        });

        Route::get('/all-order', [OrderController::class, 'allOrders'])->name('all.order');

    });
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class,'index'])->name('login');
    Route::post('/login', [LoginController::class,'login'])->name('login');
    Route::get('/register', [RegisterController::class,'index'])->name('register');
    Route::post('/register', [RegisterController::class,'register'])->name('register');
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } 
    else {
        return redirect()->route('login');
    }
});