<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //This method will show user registration page
    public function registration(){
          return view('front.account.registration');
    }

    //this method will save a user
    public function processRegistration(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique',
            'password' => 'required|min:5|same:password',
            'confirm_password' => 'required',
        ]);
          
          if($validator->passes()){
            $user=new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();

            session()->flash('sucess','You have registered successfully');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
          }else if ($validator->fails()) {
              return response()->json([
                  'status' => false,
                  'errors' => $validator->errors(),
              ]);
          }
          
    }

    //This method will show user login page
    public function login(){
        return view('front.account.login');
    }
}
