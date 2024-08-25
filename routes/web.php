<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function () {
    return view('vendor/binshopsblog/index');
});

Route::get('/blog/saved_comment', function () {
    return view('vendor/binshopsblog/saved_comment');
});

Route::get('/blog/search', function () {
    return view('vendor/binshopsblog/search');
});

Route::get('/blog/single_post', function () {
    return view('vendor/binshopsblog/single_post');
});

Route::get('/blog_admin/setup', function () {
    return view('vendor/binshopsblog/binshopsblog_admin/setup/setup');
});

// Route::get('/blog_admin', function () {
//     return view('vendor/binshopsblog/binshopsblog_admin/index');
// })->name('binshopsblog.admin.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
