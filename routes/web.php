<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\DashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IMController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MonitoringController;

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
//Route::resource('users', UserController::class)->middleware(['auth','admin']);
Route::resource('dashboard', DashboardController::class)->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
Route::resource('users', UserController::class)->middleware(['auth', 'admin']);
Route::resource('authors', AuthorController::class)->middleware('auth');
Route::resource('categories', CategoryController::class)->middleware('auth');
Route::resource('masterlist', IMController::class)->middleware('auth');
Route::resource('batches', BatchController::class)->middleware('auth');
Route::resource('purchases', PurchaseController::class)->middleware('auth');
Route::resource('reports', ReportController::class)->middleware('auth');
Route::resource('monitoring', MonitoringController::class)->middleware('auth');

// Landing Page
Route::get('/', function () {
    return view('landing_page.landing_page');
})->name('landing-page');