<?php

use App\Http\Controllers\ListingController;
//use App\Http\Controllers\ListingCrudController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// all listing

Route::get('/', [ListingController::class, 'index']);

// create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store form
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Edit Form To update
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Edit Form To update
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage listing
Route::get('/listing/manage',  [ListingController::class, 'manage'])->middleware('auth');



// Listing Resource
//Route::resource('listings', ListingCrudController::class);



// User Registeration Create
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// store Regiustration form
Route::post('/userRegistration', [UserController::class, 'store']);

// Logout 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Log In Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Logout 
Route::post('/user/login', [UserController::class, 'authenticate']);

// Manage listing
Route::get('/listing/manage',  [ListingController::class, 'manage']);
// singl listing
Route::get('/listing/{listing}',  [ListingController::class, 'show']);
