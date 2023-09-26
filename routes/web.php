<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\EstateController;

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

Route::get('/', [GuestHomeController::class, 'index'])->name('guest.home');

Route::get('/admin', [AdminHomeController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.home');

Route::prefix('/admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/estates/trash', [EstateController::class, 'trash'])->name('estates.trash'); // trash page
    Route::patch('/estates/restore', [EstateController::class, 'restoreAll'])->name('estates.restoreAll'); // restore all estates
    Route::patch('/estates/{estate}/restore', [EstateController::class, 'restore'])->name('estates.restore'); // restore an estate
    Route::delete('/estates/drop', [EstateController::class, 'dropAll'])->name('estates.dropAll'); // drop all estates from db
    Route::delete('/estates/{estate}', [EstateController::class, 'destroy'])->name('estates.destroy'); // move estate into trash
    Route::delete('/estates/{estate}/drop', [EstateController::class, 'drop'])->name('estates.drop'); // drop estate from db
    Route::resource('estates', EstateController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
