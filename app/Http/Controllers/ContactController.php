<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Contact;
use DB;
use Mail;

class ContactController extends Controller
{
    //

    function viewcontacts(){
    	$contacts = Contact::all()->toArray();
    	return view('contactform.index',compact('contacts'));
    }

    function savecontact(Request $request){
    	$this->validate($request, [
            'Name' => 'required|max:30',
    		'Surname' => 'required|max:30',
    		'E-mail' => 'required|email|max:40',
    		'Phone' => 'required|numeric|max:10',
    		'Message' => 'required',
        ]);
        $contact = new Contact([
    		'Name' => $request->get('Name'),
    		'Surname' => $request->get('Surname'),
    		'E-mail' => $request->get('E-mail'),
    		'Phone' => $request->get('Phone'),
    		'Message' => $request->get('Message'),
    	]);
    	$contact->save();
    	$success_output = "Η επικοινωνία πραγματοποιήθηκε επιτυχώς. Θα επικοινωνήσουμε σύντομα μαζί σας.";
    	return redirect()->route('contact')->with('success',$success_output);

    }

    function replyform(Request $request){
    	$mail = DB::Table('contacts')->select('E-mail as Mail')->where('id',$request->Id)->get();
    	return view('contactform.reply',compact('mail'));
    }

    function replymail(Request $request){
    	$email = $request->get('email');
    	$this->validate($request,[
    		'Reply' => 'required',
    	]);

    	Mail::send('ads.ajaxdata',
    	array('Message' => $request->get('Reply')
    	), 
    	function($message){
    		$message->from('info@walker.gr');
    		$message->to('saquib.rizwan@cloudways.com')->subject('Απάντηση σε αίτημα επικοινωνίας walker.gr');
    	});

    	return redirect()->route('contactform')->with('success','Το e-mail στάλθηκε επιτυχώς.');
    }


}
