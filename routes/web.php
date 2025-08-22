<?php

use App\Http\Controllers\HelloController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\InfoPageController;
use App\Http\Controllers\BookPageController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\ReviewPageController;
//test
//Route::get('/hello', [HelloController::class, 'index']);use Illuminate\Support\Facades\Route;
//real shi
Route::get('/', [MainPageController::class, 'index']);   // Main Page
Route::get('/info', [InfoPageController::class, 'index']); // Info Page
Route::get('/book', [BookPageController::class, 'index']); // Book Page
Route::get ('/shop', [ShopPageController::class, 'index']); //Shop Page

Route::get('/review', [ReviewPageController::class, 'showForm']); //to show revews
Route::post('/review', [ReviewPageController::class, 'submitReview']); //tp submit reviews

Route::get('/book', [BookPageController::class, 'index']);      // Show booking page
Route::post('/book', [BookPageController::class, 'submitBooking']); // Handle form submission
