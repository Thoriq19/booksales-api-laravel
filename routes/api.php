<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

// Sanctum auth user route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Public access (no login)
Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::get('genres', [GenreController::class, 'index']);
Route::get('genres/{id}', [GenreController::class, 'show']);
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{id}', [AuthorController::class, 'show']);

// User authenticated (customer)
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('transactions', [TransactionController::class, 'store']); // Buat transaksi
    Route::get('transactions/{id}', [TransactionController::class, 'show']); // Lihat transaksi
});


// Sumber daya yang dapat dilihat oleh semua pengguna (index dan show)
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);





// Rute Khusus Admin: Memerlukan otentikasi API ('auth:api') dan middleware 'admin' untuk pengecekan peran
Route::middleware(['auth:api', 'admin'])->group(function () {
    // CRUD Penuh untuk Penulis (Authors) - Admin dapat membuat, memperbarui, dan menghapus
    // (index dan show sudah ditangani di rute publik)
    Route::apiResource('authors', AuthorController::class)->except(['index', 'show']);

    // CRUD Penuh untuk Genre - Admin dapat membuat, memperbarui, dan menghapus
    // (index dan show sudah ditangani di rute publik)
    Route::apiResource('genres', GenreController::class)->except(['index', 'show']);

    // CRUD Penuh untuk Buku - Admin dapat membuat, memperbarui, dan menghapus
    // (index dan show sudah ditangani di rute publik)
    Route::apiResource('books', BookController::class)->except(['index', 'show']);

    // Akses spesifik Admin untuk Transaksi:
    // Admin dapat melihat semua transaksi (index)
    Route::get('transactions', [TransactionController::class, 'index']);
    // Admin dapat memperbarui transaksi berdasarkan ID (update)
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    // Admin dapat menghapus transaksi berdasarkan ID (destroy)
    // (store dan show untuk transaksi ditangani oleh rute pengguna terotentikasi/customer)
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);
});
