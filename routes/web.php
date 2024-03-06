<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* ! users */
Route::get('users', [UserController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('users');
Route::get('users/create', [UserController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('employee.create');
Route::post('users', [UserController::class, 'store'])
    ->name('employee.store');
Route::get('users/{id}', [UserController::class, 'edit'])
    ->name('employee.edit');
Route::put('users/{id}', [UserController::class, 'update'])
    ->name('employee.update');
Route::delete('users/{id}', [UserController::class, 'destroy']
)->name('exclude.employee');


/* ! customers */
Route::get('customers', [CustomerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('customers');
Route::get('customers/create', [CustomerController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('customer.create');
Route::post('customers', [CustomerController::class, 'store'])
    ->name('customer.store');
Route::get('customers/{id}', [CustomerController::class, 'edit'])
    ->name('customer.edit');
Route::put('customers/{id}', [CustomerController::class, 'update'])
    ->name('customer.update');
Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

/* ! customers */
Route::get('products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('products');
Route::get('products/create', [ProductController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])
    ->name('products.store');
Route::get('products/{id}', [ProductController::class, 'edit'])
    ->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])
    ->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])
    ->name('products.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
