<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

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

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/account/register', [AccountController::class, 'registration'])->name('front.account.registration');
Route::post('/account/register', [AccountController::class, 'processRegistration'])->name('front.account.processRegistration');
Route::get('/account/login', [AccountController::class, 'login'])->name('front.account.login');
