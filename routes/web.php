<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function(){
    return redirect('admin/auth/login');
});

Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Invalid credential! or unauthenticated.']);
    return response()->json([
        'errors' => $errors
    ], 401);
})->name('authentication-failed');

// routes/web.php
Route::get('/run-storage-link', function() {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/check-image', function () {
    $path = storage_path('app/public/shop/2025-11-18-691c3fec20ca7.png');

    return [
        'symlink_exists' => file_exists(public_path('storage')),
        'file_exists' => file_exists($path),
        'path' => $path
    ];
});

Route::get('/run-artisan', function () {
    
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'All caches cleared successfully!';
});



