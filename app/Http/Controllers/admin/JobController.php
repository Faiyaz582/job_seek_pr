<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->with('user', 'applications')->paginate(10);
        return view('admin.jobs.list', [
            'jobs' => $jobs
        ]);
    }


    public function edit($id)
    {
        $job = Job::findOrFail($id);

        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();



        return view('admin.jobs.edit',[
            'job' => $job,
            'categories' => $categories,
            'jobTypes' => $jobTypes
        ]);
    }

    public function update(Request $request,$id)
     {
         // Define validation rules
         $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'job_location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
         ];
     
         // Run validation
         $validator = Validator::make($request->all(), $rules);
     
        // if ($validator->fails()) {
        //     return response()->json([
         //        'status' => false,
         //        'errors' => $validator->errors(),
        //     ]);
        // }
     
         // Store Job
         if($validator->passes()){

            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->job_location;  
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibilities = $request->responsibility;
            $job->qualification = $request->qualifications;
            $job->experience = $request->experience;
            $job->keywords = $request->keywords;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;

            $job->status = $request->status; 
            $job->isFeature = (!empty($request->isFeature)) ? $request->isFeature : 0; 
 
            $job->save();

             session()->flash('success', 'Job updated successfully');
     
             return response()->json([
                 'status' => true,
                 'errors' => [],
             ]);
         } else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
         }

     }

     public function destroy(Request $request)
     {
        $id = $request->id;

        $job = Job::find($id);

        if($job==null){
            session()->flash('error', 'Either Job Deleted or Job not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $job->delete();

        session()->flash('success', 'Job deleted successfully');
        return response()->json([
            'status' => true,
        ]);

     }
    
}
