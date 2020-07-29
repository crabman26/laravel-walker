<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class MainController extends Controller
{
    //
    function about(){
    	return view('main.about');
    }

    function contact(){
    	return view('main.contact');
    }

    function terms(){
    	return view('main.terms');
    }

    function login(){
    	return view('main.login');
    }

    function memberads(){
        return view('member.memberads');
    }

    function memberprofile(){
        return view('member.memberprofile');
    }

    function checklogin(Request $request){
        $this->validate($request, [
          'email'   => 'required|email',
          'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
          'email'  => $request->get('email'),
          'password' => $request->get('password')
        );

        if(Auth::attempt($user_data))
         {
          return redirect('main/successlogin');
         } else
         {
          return back()->with('error', 'Wrong Login Details');
         }

    }

    function successlogin(){
        return view('ads.ajaxdata');
    }

    function logout(){
        Auth::logout();
        return redirect('index');
    }
}
