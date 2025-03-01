<?php
// JObs controller
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Mail\JobNotificationEmail;
use App\Models\JobType;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $count=0;
        if(Auth::user())
       {  $count=  SavedJob::where([
            'user_id' =>Auth::user()->id,
            'job_id' => $id
        ])->count();
       }

       //fetch applicants
       $application = JobApplication::where('job_id',$id)->with('user')->get();

       // dd($job);
 // This will output the full $job object and show you all its properties.


        return view('front.jobDetail', ['job' => $job, 'count' => $count , 'applications'=>$application]);
    } 
    
    public function applyJob(Request $request){
        $id = $request->id;

        $job =Job::where('id',$id)->first();

      //  dd($job);

        //if job is null/not found in db
        if($job == null){
            $message='Job doesnt exist.';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message

            ]);
        }

        //you can not apply on your own job.
        $employer_id= $job->user_id;

        if($employer_id == Auth::user()->id) {
            $message = 'You can not apply on your own job.';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message

            ]);

        }

        //you can not apply on a  job twice.
        $jobApplicationCount = JobApplication::where([
            'user_id'=>Auth::user()->id,
            'job_id'=>$id
        ])->count();

        if($jobApplicationCount>0){
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status'=>false,
                'message'=>$message

            ]);

        }

        $application = new JobApplication;
        $application -> job_id = $id;
        $application -> user_id =Auth::user()->id;
        $application -> employer_id =$employer_id;
        $application->applied_date = now();
        $application->save();


        //sent notifiaction email to employer
        $employer=User::where('id',$employer_id)->first();
        $mailData=[
            'employer'=>$employer,
            'user'=>Auth::user(),
            'job'=>$job,
        ];
        
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        $message='You have successfully applied.';

        session()->flash('success',$message);
            return response()->json([
                'status'=>true,
                'message'=>$message

            ]);


    }

    public function saveJob(Request $request){
        $id = $request->id;

        $job = Job::find($id); 

        if($job == null){
            session()->flash('error','Job not found');
            return response()->json([
                'status' => false,
            ]);
        }
        //if user has already saved the job
        $count=  SavedJob::where([
            'user_id' =>Auth::user()->id,
            'job_id' => $id
        ])->count();

        if($count>0)
        {
            session()->flash('error', 'You already saved this job.');

            return response()->json([
                'status' => false,
            ]);
        }

        $savedJob = new SavedJob;
        $savedJob-> job_id =$id;
        $savedJob-> user_id =Auth::user()->id;
        $savedJob-> save();

        session()->flash('success', 'You have saved the job.');

        return response()->json([
            'status' => true,
        ]);
    }
}
