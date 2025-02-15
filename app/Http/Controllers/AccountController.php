<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    //this method will shiw user registrantion page
    public function registration(){

        return view('front.account.registration');

    }

     //this method will save a user 
     public function processRegistration(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:5|same:confirm_password',
            'confirm_password' => 'required',


        ]);

        if($validator->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->save();

            session()->flash('success','You have registered successfully.');

            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
            ]);
        
        }

     }

     //this method will show user login page
     public function login () {
        return view ('front.account.login');
     }

     public function profile () {

         //for getting logged in user id
        $id=Auth::user()->id;
        //dd($id);   
         //$user=User::find($id);->This can be used as well for fetching user info

        $user=User::where('id',$id)->first();
        return view ('front.account.profile',[
            'user'=>$user,
        ]);
     }
       

    public function authenticate(Request $request){
        //for validation
        
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->passes()){
           
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
               return redirect()->route('front.account.profile');

            }else{
                return redirect()->route('front.account.login')
                ->with('error','Either email/password is incorrect');
            }
        }
        else{
            //redirect to route page with validation errors and email is not required next time for login
            return redirect()->route('front.account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }    
        
    }    


    public function updateProfile(Request $request){
        
        $id=Auth::user()->id;
        
        $validator=Validator::make($request->all(),[
         'name'=>'required|min:5|max:20',
         'email'=>'required|email|unique:users,email,'.$id.',id',
        ]);

        if($validator->passes()){
            //for updating the data
            $user=User::find($id);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->mobile=$request->mobile;
            $user->designation=$request->designation;
            $user->save();
          

            session()->flash('success','Profile updated successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[],
            ]);
        
        
        
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
            ]);
        }
    }
     public function logout () {
        Auth::logout();
        return redirect ()->route('front.account.login');
     }

     public function updateProfilePic(Request $request){
        //dd($request->all());

         $id=Auth::user()->id;

        $validator=Validator::make($request->all(),[
            'image'=>'required|image'
        ]);

        if($validator->passes()){
           $image=$request->image;
           //for finding the exension of the image
           $ext=$image->getClientOriginalExtension();
           //for generating unique name of image
           $imageName=$id.'-'.time().'-'.$ext;
           $image->move(public_path('/profile_pic/'),$imageName);

           //Create  a small thumbnail
           $sourcePath=public_path('/profile_pic/'.$imageName);
           $manager = new ImageManager(Driver::class);
           $image = $manager->read($sourcePath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));
           
            //delete old profile pic
            File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
            File::delete(public_path('/profile_pic/'.Auth::user()->image));

            //for updating data in db
           User::where('id',$id)->update(['image'=>$imageName]);

           session()->flash('success','Profile Pic Updated Successfully.');

           return response()->json([
            'status'=>true,
            'errors'=>[],
            ]);

           
        }else{
            return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
            ]);
        }
     }


     public function createJob(){

        $Categories= Category::orderBy('name', 'ASC')->where('status',1)->get();
        $JobTypes = JobType::orderBy('name', 'ASC')->where('status',1)->get();
        return view('front.account.job.create', [
            'categories'=>$Categories,
            'jobTypes'=>$JobTypes,

        ]);
     }

     public function saveJob(Request $request)
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
     
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'errors' => $validator->errors(),
             ]);
         }
     
         // Store Job
         $job = new Job();
         $job->title = $request->title;
         $job->category_id = $request->category;
         $job->job_type_id = $request->jobType;
         $job->user_id =Auth::user()->id;
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
         $job->save();
     
         session()->flash('success', 'Job added successfully');
     
         return response()->json([
             'status' => true,
             'message' => 'Job saved successfully',
         ]);
     }
     


public function myJobs(){
    $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')->paginate(10);
    

    return view('front.account.job.myJobs',[
        'jobs'=> $jobs
    ]);
}

public function editJob(Request $request,$id){
    
    $categories= Category::orderBy('name', 'ASC')->where('status',1)->get();
    $jobTypes = JobType::orderBy('name', 'ASC')->where('status',1)->get();
    
    $job=Job::where([
        'user_id'=>Auth::user()->id,
        'id'=>$id
    ])->first();

    if($job==null){
        abort(404); //for displaying 404 page
       }
    return view('front.account.job.edit',[
        'categories'=>$categories,
         'jobTypes'=>$jobTypes,
          'job'=>$job,
    ]);
}


public function updateJob(Request $request,$id)
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
     
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'errors' => $validator->errors(),
             ]);
         }
     
         // Store Job
         $job = Job::find($id);
         $job->title = $request->title;
         $job->category_id = $request->category;
         $job->job_type_id = $request->jobType;
         $job->user_id =Auth::user()->id;
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
         $job->save();
     
         session()->flash('success', 'Job updated successfully');
     
         return response()->json([
             'status' => true,
             'message' => 'Job saved successfully',
         ]);
     }  
     
     public function deleteJob(Request $request){
        $job=Job::where([
          'user_id'=>Auth::user()->id, //only that particular user can edit,for logged in user id
          'id'=>$request->jobId
        ])->first();

        if($job==null){
          session()->flash('error','Either job deleted or not found');
          return response()->json([
              'status'=>true
          ]);
        }

        Job::where('id',$request->jobId)->delete();
        session()->flash('success','Job deleted successfully');
          return response()->json([
              'status'=>true
          ]);
   }
}