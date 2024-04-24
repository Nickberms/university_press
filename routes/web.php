<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\http\Controllers\DashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IMController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\AdjustmentLogController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\TopSaleController;
use App\Http\Controllers\UserController;

Auth::routes([
    'verify' => true
]);
Route::get('/', function () {
    return view('landing_page');
})->name('landing-page');
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('masterlist', IMController::class);
    Route::resource('batches', BatchController::class);
    Route::resource('adjustment_logs', AdjustmentLogController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('monitoring', MonitoringController::class);
    Route::resource('top_sales', TopSaleController::class);
});
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
});