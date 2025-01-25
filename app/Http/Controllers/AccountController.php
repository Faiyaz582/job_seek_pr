<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
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
                'errors'=>$validator->errors()
            ]);
        
        }

     }

     //this method will shiw user login page
     public function login () {
        return view ('front.account.login');
     }

     public function profile () {
        return view ('front.account.profile');
     }
       
    //  public function logout () {
    //     Auth::logout();
    //     return redirect ()->route('front.account.login');
    //  }
}

