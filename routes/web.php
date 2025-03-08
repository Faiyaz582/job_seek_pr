<?php
// Routing
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;

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
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');
Route::get('/jobs/detail{id}',[JobsController::class,'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob');


Route::group(['prefix'=>'admin','middleware'=>'checkRole'],function(){
  Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
  Route::get('/users',[UserController::class,'index'])->name('admin.users');
  Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
  Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
  Route::delete('/users',[UserController::class,'destroy'])->name('admin.users.delete');
  Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
  Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
  Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
  Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.jobs.destroy');
  Route::get('/jobs-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');




});


//redirect the guest route back to guest route without authentication

Route::group(['prefix'=>'account'],function(){
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
        Route::get('/account/my-job-applications',[AccountController::class,'myJobApplications'])->name('front.account.myJobApplications');        
        Route::post('/account/remove-job-applications',[AccountController::class,'removeJobs'])->name('front.account.removeJobs'); 
        Route::get('/account/saved-jobs',[AccountController::class,'savedJobs'])->name('front.account.savedJobs');        
        Route::post('/account/remove-saved-job-applications',[AccountController::class,'removeSavedJobs'])->name('front.account.removeSavedJobs'); 

      });
});



                                                                                                                           