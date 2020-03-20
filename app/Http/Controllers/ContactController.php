<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $contacts = Contact::all()->toArray();
        return view('contactform.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(),
        [
            'Name' => 'required',
            'Surname' => 'required',
            'E-mail' => 'required',
            'Phone' => 'required',
            'Message' => 'required'
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails()){
            foreach ($validation->messages()->getMessages() as $field_name => $message){
                $error_array[] = $message; 
            }
        } else {
            $contact = new Contact([
                'Name' => $request->get('Name'),
                'Surname' => $request->get('Surname'),
                'E-mail' => $request->get('E-mail'),
                'Phone' => $request->get('Phone'),
                'Message' => $request->get('Message'),
            ]);
            $contact->save();
            $success_output = 'Η επικοινωνία πραγματοποιήθηκε επιτυχώς, θα επικοινωνήσουμε σύντομα μαζί σας.';
            return redirect()->route('contact')->with('success',$success_output);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
