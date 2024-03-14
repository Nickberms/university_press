<?php
use Illuminate\Support\Facades\Route;
use App\http\Controllers\DashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IMController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PurchaseController;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
//Route::resource('users', UserController::class)->middleware(['auth','admin']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/daily_monitoring', function () {
    return view('sales_management.daily_monitoring');
});
Route::get('/inventory_report', function () {
    return view('sales_management.inventory_report');
});
Route::resource('authors', AuthorController::class)->middleware('auth');
Route::resource('categories', CategoryController::class)->middleware('auth');
Route::resource('instructional_materials', IMController::class)->middleware('auth');
Route::resource('batches', BatchController::class)->middleware('auth');
Route::resource('purchases', PurchaseController::class)->middleware('auth');