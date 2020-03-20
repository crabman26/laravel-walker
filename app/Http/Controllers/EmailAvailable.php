<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\User;

class EmailAvailable extends Controller
{
    //
    function index(){
    	return view('main.register');
    }

    function check(Request $request)
    {
     if($request->get('email'))
     {
      $email = $request->get('email');
      $data = DB::table("users")
       ->where('email', $email)
       ->count();
      if($data > 0)
      {
       echo 'not_unique';
      }
      else
      {
       $validation = Validator::make($request->all(),[
        'email' => 'required',
        'name' => 'required',
        'password' => 'required'
       ]);
       $error_array = array();
       $success_output = '';
       if ($validation->fails()){
        foreach($validation->messages()->getMessages() as $field_name => $message){
          $error_array[] = $message; 
        }
       } else {
        $user = new User([
          'email' => $request->get('email'),
          'name' => $request->get('name'),
          'password' => $request->get('password')
        ]);
        $user->save();
        $success_output = 'Η επικοινωνία πραγματοποιήθηκε επιτυχώς, θα επικοινωνήσουμε σύντομα μαζί σας.';
        return redirect()->route('register')->with('success',$success_output);
       }

       echo 'unique';
      }
     }
    }
}
