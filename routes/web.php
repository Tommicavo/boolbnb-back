<?php

use App\Http\Controllers\Admin\EstateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;


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

Route::get('/', [HomeController::class, 'index'])->name('guest.home');

Route::prefix('/admin')->middleware('auth', 'verified')->name('admin.')->group(function () {
    Route::get('/estates/trash', [EstateController::class, 'trash'])->name('estates.trash'); // trash page
    Route::get('/estates/messages', [EstateController::class, 'messages'])->name('estates.messages'); // messages page
    Route::get('/estates/{estate}/promo', [EstateController::class, 'promo'])->name('estates.promo'); // Promo page
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

use Illuminate\Support\Facades\Http;

Route::get('/proxy/{query}', function ($query) {
    $url = "https://api.tomtom.com/search/2/search/$query.json";
    $response = Http::get($url, [
        'key' => 'M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW',
        'limit' => 5,
        'countrySet' => 'IT',
    ]);

    return response()->json($response->json());
});

require __DIR__ . '/auth.php';
