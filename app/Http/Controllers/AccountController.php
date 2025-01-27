<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
}

