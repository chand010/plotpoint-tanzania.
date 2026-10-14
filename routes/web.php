<?php

use App\Http\Controllers\AdminPropertyReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SellerPropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('seller')->name('seller.')->group(function (): void {
    Route::get('/properties', [SellerPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [SellerPropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [SellerPropertyController::class, 'store'])->middleware('throttle:10,1')->name('properties.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/properties', [AdminPropertyReviewController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [AdminPropertyReviewController::class, 'show'])->name('properties.show');
    Route::post('/properties/{property}/verify-seller', [AdminPropertyReviewController::class, 'verifySeller'])->middleware('throttle:10,1')->name('properties.verify-seller');
    Route::post('/properties/{property}/review', [AdminPropertyReviewController::class, 'reviewProperty'])->middleware('throttle:10,1')->name('properties.review-property');
});
