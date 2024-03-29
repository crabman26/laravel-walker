<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\Contact;
use App\Mail\ContactAnswer;
use DB;

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
         
        return view('contactform.index');
    }

    public function getdata(Request $request){
        if (request()->ajax()){
            $contacts = DB::table('contacts')
                ->select('contacts.id','contacts.Name','contacts.Surname','contacts.E-mail','contacts.Phone','contacts.Message','contacts.Answer');

            return DataTables::of($contacts)
                ->addColumn('action',function($contact){
                    return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$contact->id.'"><i class="glyphicon glyphicon-edit"></i> Απάντηση</a>';
                })
                    ->rawColumns(['action'])
                    ->make(true);
        }

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
                'Answer' => 'No'
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

    public function answer(Request $request) {
        $validation = Validator::make($request->all(),[
            'Text' => 'required',
        ]);
        $error_array = array();
        $success_output = '';
         if ($validation->fails()) {
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        } else {
            $text = $request->get('Text');
            Mail::to($request->user())->send(new ContactAnswer($text));
            $success_output = '<div class="alert alert-success">Η απάντηση στάλθηκε επιτυχώς.</div>';
            $output = array(
                'error' => $error_array,
                'success' => $success_output
            );
            $contact = Contact::find($request->get('contact_id'));
            $contact->Answer = 'Yes';
            $contact->save();
            echo json_encode($output);
        }
    }
}
