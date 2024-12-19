<?php

use Illuminate\Support\Facades\Route;

//Namespace Auth
use App\Http\Controllers\Auth\LoginController;

//Namespace Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
//Namespace User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\ReceiptController;

use Illuminate\Support\Facades\Auth;

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

// Route::view('/', 'welcome');
Route::view('/', 'auth.login')->name('logina');


Route::group(['namespace' => 'Admin', 'middleware' => 'auth', 'prefix' => 'admin'], function () {

	Route::get('/', [AdminController::class, 'index'])->name('admin')->middleware(['can:admin']);

	//Route Rescource
	Route::resource('/user', 'UserController')->middleware(['can:admin']);

	//Route View

	Route::view('/404-page', 'admin.404-page')->name('404-page');
	Route::view('/blank-page', 'admin.blank-page')->name('blank-page');
	Route::view('/buttons', 'admin.buttons')->name('buttons');
	Route::view('/cards', 'admin.cards')->name('cards');
	Route::view('/utilities-colors', 'admin.utilities-color')->name('utilities-colors');
	Route::view('/utilities-borders', 'admin.utilities-border')->name('utilities-borders');
	Route::view('/utilities-animations', 'admin.utilities-animation')->name('utilities-animations');
	Route::view('/utilities-other', 'admin.utilities-other')->name('utilities-other');
	Route::view('/chart', 'admin.chart')->name('chart');
	Route::view('/tables', 'admin.tables')->name('tables');

	Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
	Route::get('/receipts/edit/{id}', [ReceiptController::class, 'edit'])->name('receipts.edit');
	Route::put('/receipts/update/{id}', [ReceiptController::class, 'update'])->name('receipts.update');

	Route::get('/receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');
	Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipts.store');
	Route::get('/receipts/{id}', [ReceiptController::class, 'show'])->name('receipts.show');

	Route::get('/product', [ProductController::class, 'index'])->name('product.index');
	Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
	Route::post('/product', [ProductController::class, 'store'])->name('product.store');
	Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
	Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
	Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

	Route::get('/download-receipt/{id}', [ReceiptController::class, 'downloadReceipt'])->name('receipts.download');
});

Route::group(['namespace' => 'User', 'middleware' => 'auth', 'prefix' => 'user'], function () {
	Route::get('/', [UserController::class, 'index'])->name('user');
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	Route::patch('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
	Route::view('/login', 'auth.login')->name('login');
	Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
});

// Other
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');
Route::post('/logout', function () {
	return redirect()->to('/login')->with(Auth::logout());
})->name('logout');
