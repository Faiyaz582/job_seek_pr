<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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



//redirect the guest route back to guest route without authentication

Route::group(['account'],function(){
      //Guest Route
      Route::group(['middleware'=>'guest'],function(){
          Route::get('/account/register',[AccountController::class,'registration'])->name('front.account.registration');
          Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('front.account.processRegistration');
          Route::post('/account/authenticate',[AccountController::class,'authenticate'])->name('front.account.authenticate');
          Route::get('/account/login',[AccountController::class,'login'])->name('front.account.login');
      });

      //Authenticated Routes
      Route::group(['middleware'=>'auth'],function(){
        Route::get('/account/profile',[AccountController::class,'profile'])->name('front.account.profile');
        Route::put('/account/update-profile',[AccountController::class,'updateProfile'])->name('front.account.updateProfile');    
        Route::get('/account/logout',[AccountController::class,'logout'])->name('front.account.logout');  
        Route::post('/account/update-profile-pic',[AccountController::class,'updateProfilePic'])->name('front.account.updateProfilePic'); 
        Route::get('/account/create-job',[AccountController::class,'createJob'])->name('front.account.createJob');  
        Route::post('/account/save-job',[AccountController::class,'saveJob'])->name('front.account.saveJob');
        Route::get('/account/my-jobs',[AccountController::class,'myJobs'])->name('front.account.myJobs');        
        Route::post('/account/update-job/{jobId}',[AccountController::class,'updateJob'])->name('front.account.updateJob'); 
        Route::get('/account/my-jobs/edit/{jobId}',[AccountController::class,'editJob'])->name('front.account.editJob');
        Route::post('/account/delete-job',[AccountController::class,'deleteJob'])->name('front.account.deleteJob');        
    });
});



                                                                                                                           