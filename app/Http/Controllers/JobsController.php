<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    //This method will show jobs page
    public function index(Request $request){

        $category=Category::where('status',1)->get();   
        $jobType=JobType::where('status',1)->get();  
        
        $jobs=Job::where('status',1);

        //search using keyword
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere('title', 'like', '%'.$request->keyword.'%');
                $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }

        //search using location
        if(!empty($request->location)){
            $jobs = $jobs->where('location', $request->location);
        }

        //search using category
        if(!empty($request->category)){
            $jobs = $jobs->where('category_id', $request->category);
        }

        $jobTypeArray = [];
        //search using job type
        if(!empty($request->jobType)){
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

         //search using experience
         if(!empty($request->experience)){
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with(['jobType','category']);

        if ( $request->sort=='0'){
            $jobs = $jobs->orderBy('created_at','ASC');
        }else{
            $jobs = $jobs->orderBy('created_at','DESC');
        }
        
        
        $jobs = $jobs->paginate(9);

        return view('front.jobs',[
            'category'=>$category,
            'jobType'=>$jobType,
            'jobs'=>$jobs,
            'jobTypeArray' => $jobTypeArray

        ]);
    }


    //this method will show job detail page
    public function detail ($id) {

        $job = Job::where([
                            'id'=> $id, 
                            'status' => 1 //active jobs e dekhabe shudhu eta diye
                        ])->With (['jobType', 'category'])-> first();
            
        if($job == null){
            abort(404);
        }

       // dd($job);
 // This will output the full $job object and show you all its properties.


        return view('front.jobDetail', ['job' => $job]);
    }
}
