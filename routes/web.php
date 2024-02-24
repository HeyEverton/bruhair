<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::delete('exclude/{id}', [UserController::class, 'destroy'])->name('exclude.employee');
});

require __DIR__ . '/auth.php';
