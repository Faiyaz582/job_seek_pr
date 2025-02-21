<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    //This method will show jobs page
    public function index(){

        $category=Category::where('status',1)->get();   
        $jobType=JobType::where('status',1)->get();  
        
        $jobs=Job::where('status',1)->with('jobType')->orderBy('created_at','DESC')->paginate(9);

        return view('front.jobs',[
            'category'=>$category,
            'jobType'=>$jobType,
            'jobs'=>$jobs,

        ]);
    }
}
