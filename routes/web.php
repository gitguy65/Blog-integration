<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use BinshopsBlog\Controllers\BinshopsReaderController; 
// use App\Http\Middleware\SetBlogLocale;
// use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;


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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('blog', function(Request $request) {
//     $request->merge(['locale' => 'en']);
//     return app(BinshopsReaderController::class)->index('en', $request, null);
// });

// Route::get('blog/category', function(Request $request) {
//     $request->merge(['locale' => 'en']);
//     return app(BinshopsReaderController::class)->view_category($request);
// });

// Route::get('blog/search', function(Request $request) {
//     $request->merge(['locale' => 'en']);
//     return app(BinshopsReaderController::class)->search($request);
// });

// Route::get('blog/post', function(Request $request) {
//     $request->merge(['locale' => 'en']);
//     return app(BinshopsReaderController::class)->viewSinglePost($request);
// });  
Route::get('blog', [BlogController::class, 'index']);

Route::get('blog/category', [BlogController::class, 'index']);

Route::get('blog/search', [BlogController::class, 'search']);

Route::get('blog/{post_slug}', [BlogController::class, 'viewSinglePost'])->name('blog.view_single_post');

Route::get('blog/post', [BlogController::class, 'viewSinglePost']);

Auth::routes();

