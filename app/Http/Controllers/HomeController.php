<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Method to show Home Page
    public function index(){
        //for fetching active category
        $categories=Category::where('status',1)->orderBy('name','ASC')->take(8)->get();

        $featuredJobs=Job::where('status',1)
                      ->orderBy('created_at','DESC')
                      ->with('jobType')
                      ->where('isFeature',1)->take(6)->get();  //for showing only 6 featured jobs

        $latestJobs=Job::where('status',1)
                      ->with('jobType')
                      ->orderBy('created_at','DESC')
                      ->take(6)->get(); 

        return view('front.home',[
            'categories'=>$categories,
            'featuredJobs'=>$featuredJobs,
            'latestJobs'=>$latestJobs
        ]);
    }

}
