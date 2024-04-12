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

Auth::routes([
    'verify' => true
]);
Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
Route::resource('users', UserController::class)->middleware(['auth', 'verified', 'admin']);
Route::resource('authors', AuthorController::class)->middleware(['auth', 'verified']);
Route::resource('categories', CategoryController::class)->middleware(['auth', 'verified']);
Route::resource('masterlist', IMController::class)->middleware(['auth', 'verified']);
Route::resource('batches', BatchController::class)->middleware(['auth', 'verified']);
Route::resource('purchases', PurchaseController::class)->middleware(['auth', 'verified']);
Route::resource('reports', ReportController::class)->middleware(['auth', 'verified']);
Route::resource('monitoring', MonitoringController::class)->middleware(['auth', 'verified']);
Route::get('/', function () {
    return view('landing_page.landing_page');
})->name('landing-page');
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});