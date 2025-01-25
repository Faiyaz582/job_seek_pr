<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    //this method will show user registration page
    public function registration () {
        return view ('front.account.registration');
    }

     //this method will show user login page
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
