<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use BinshopsBlog\Controllers\BinshopsReaderController;
// use App\Http\Middleware\SetBlogLocale;
use Illuminate\Http\Request;

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

Route::get('blog', function(Request $request) {
    $request->merge(['locale' => 'en']);
    return app(BinshopsReaderController::class)->index('en', $request, null);
});

Route::get('blog/category', function(Request $request) {
    $request->merge(['locale' => 'en']);
    return app(BinshopsReaderController::class)->view_category($request);
});

Route::get('blog/search', function(Request $request) {
    $request->merge(['locale' => 'en']);
    return app(BinshopsReaderController::class)->search($request);
});

Route::get('blog/post', function(Request $request) {
    $request->merge(['locale' => 'en']);
    return app(BinshopsReaderController::class)->viewSinglePost($request);
});  

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
