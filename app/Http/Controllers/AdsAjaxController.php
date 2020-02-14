<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ads;
use DataTables;
use Validator;

class AdsAjaxController extends Controller
{
    //
    function index(){
        
    	return view('ads.ajaxdata');
    }

    function getdata(){
    	$ads = Ads::select('id','Name','Surname','Town','Region','Email','Description','State');
    	return DataTables::of($ads)
            ->addColumn('action', function($ad){
                return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$ad->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$ad->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="ad_checkbox[]" class="ad_checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
    		->make(true);
    }

    function postdata(Request $request){
    	$validation = Validator::make($request->all(),[
    		'Name' => 'required',
    		'Surname' => 'required',
    		'Town' => 'required',
    		'Region' => 'required',
    		'E-mail' => 'required',
    		'Description' => 'required',
    		'State' => 'required',
    	]);
    	$error_array = array();
    	$success_output = '';
    	if ($validation->fails()){
    		foreach($validation->messages()->getMessages() as $field_name => $messages){
    			$error_array[] = $messages;
    		}
    	} else {
    		if($request->get('button_action') == "Insert"){
    			$ad = new Ads([
    				'Name' => $request->get('Name'),
    				'Surname' => $request->get('Surname'),
    				'Town' => $request->get('Town'),
    				'Region' => $request->get('Region'),
    				'Email' => $request->get('E-mail'),
    				'Description' => $request->get('Description'),
    				'State' => $request->get('State')
    			]);
    			$ad->save();
    			$success_output = '<div class="alert alert-success">Ad inserted succesfully.</div>';
    		}
            if($request->get('button_action') == 'Update')
            {
                $ad = Ads::find($request->get('ads_id'));
                $ad->Name = $request->get('Name');
                $ad->Surname = $request->get('Surname');
                $ad->Town = $request->get('Town');
                $ad->Region = $request->get('Region');
                $ad->Email = $request->get('E-mail');
                $ad->Description = $request->get('Description');
                $ad->State = $request->get('State');
                $ad->save();
                $success_output = '<div class="alert alert-success">Ad updated succesfully.</div>';
            }
    		$output = array(
    			'error' => $error_array,
    			'success' => $success_output
    		);
    		echo json_encode($output);
    	}
    }

    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $ad = Ads::find($id);
        $output = array(
            'Name'    =>  $ad->Name,
            'Surname'     =>  $ad->Surname,
            'Town'     =>  $ad->Town,
            'Region'     =>  $ad->Region,
            'Email'     =>  $ad->Email,
            'Description'     =>  $ad->Description,
            'State'     =>  $ad->State
        );
        echo json_encode($output);
    }

    function removedata(Request $request){
        $id = $request->input('id');
        $ad = Ads::find($id);
        if ($ad->delete()){
            echo 'Ad deleted succesfully.';
        }
    }

    function massremove(Request $request){
        $ads_id_array = $request->input('id');
        $ad = Ads::whereIn('id', $ads_id_array);
        if ($ad->delete()){
            echo 'Ads deleted succesfully';
        } 
    }

}
