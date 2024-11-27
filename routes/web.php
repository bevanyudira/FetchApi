<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Auth\LoginRegisterController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/buku/show/{id}', [BukuController::class, 'show']) -> name('buku.show');
    Route::put('/buku/{id}', [BukuController::class, 'update']) -> name('buku.update');
    Route::delete('/buku{id}', [BukuController::class, 'destroy']) -> name('buku.destroy');
    Route::get('buku/create', [BukuController::class, 'create']) -> name('buku.create');
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/buku', [BukuController::class, 'store']) -> name('buku.store');

    Route::get('/buku/showphoto/{filename}', [BukuController::class, 'showphoto']) -> name('buku.showphoto');

    Route::resource('gallery', GalleryController::class);

});


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->name('logout');
   });


   // Route untuk halaman view books_api
Route::get('/books/api', [BookApiController::class, 'viewBooksApi']);



