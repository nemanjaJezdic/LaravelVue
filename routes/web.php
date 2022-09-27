<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckMiddleware;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/reaction', function () {
//     return view('reaction');
// });

Route::get('/',[UserController::class,'index'])->name('home');
Route::post('/register',[UserController::class,'register'])->name('register');
Route::post('/login',[UserController::class,'login'])->name('login');
Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/form',[FormController::class,'index'])->name("form");
Route::post('/storein',[FormController::class,'storeInsurance'])->name('storein');

Route::get('/admin/news',[FormController::class,'adminNews'])->name("admin.news");
Route::get('/news',[FormController::class,'getNews'])->name("news");

Route::middleware([LoginMiddleware::class])->group(function(){
    Route::get('/admin',[FormController::class,'adminList'])->name("admin");
    Route::get('/admin/insurance',[FormController::class,'adminInsurance'])->name("admin.insurance");
    Route::post('/storenews',[FormController::class,'storeNews'])->name('storenews');
    Route::get('/admin/onenews',[FormController::class,'adminNewsOne'])->name("admin.newsone");
    Route::get('/admin/delete/{id}',[FormController::class,'deleteNews'])->name("admin.delete");
    Route::get('/admin/publish/{id}',[FormController::class,'publishNews'])->name("admin.publish");
    Route::get('/admin/archive/{id}',[FormController::class,'archiveNews'])->name("admin.archive");
    Route::post('/admin/persons',[FormController::class,'getPersons'])->name("admin.persons");
});
