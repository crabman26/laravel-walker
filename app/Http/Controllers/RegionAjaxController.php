<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Regions;
use Validator;

class RegionAjaxController extends Controller
{
    //
    function index(){
    	return view('regions.index');
    }

    function getdata(){
    	$regions = Regions::select('id','Name');
    	return DataTables::of($regions)
    	->addcolumn('action',function($region){
    		 return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$region->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$region->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
    	})
    	->addcolumn('checkbox','<input type="checkbox" class="region_checkbox" value={{$id}} name="region_checkbox[]"/>')
    	->rawcolumns(['checkbox','action'])
    	->make(true);
    }

    function postdata(Request $request){
    	$validation = Validator::make($request->all(),[
    		'Name' => 'required'
    	]);
    	$error_array = array();
    	$success_output = '';
    	if ($validation->fails()){
    		foreach ($validation->messages()->getMessages() as $field_name => $messages){
    			$error_array[] = $messages; 
    		}
    	} else {
    		if ($request->get('button_action') == "Insert"){
	    		$region = new Regions([
	    			'Name' => $request->get('Name')
	    		]);
	    		$region->save();
	    		$success_output = '<div class="alert alert-success">Region inserted succesfully.</div>';
    		} if ($request->get('button_action') == "Update"){
    			$region = Regions::find($request->get('region_id'));
    			$region->Name = $request->get('Name');
    			$region->save();
    			$success_output = '<div class="alert alert-success">Region updated succesfully.</div>';
    		}
    	}

    	$output = array(
    		'error' => $error_array,
    		'success' => $success_output
    	);

    	echo json_encode($output);
    }

    function fetchdata(Request $request){
    	$id = $request->input('id');
    	$region = Regions::find($id);
    	$output = array([
    		'Name' => $region->Name
    	]);

    	echo json_encode($output);
    }

    function removedata(Request $request){
    	$id = $request->input('id');
    	$region = Regions::find($id);
    	if ($region->delete()){
    		echo 'Region deleted succesfully';
    	}
    }

    function massremove(Request $request){
    	$region_id_array = $request->input('id');
    	$region = Regions::WhereIn('id',$region_id_array);
    	if ($region->delete()){
    		echo 'Regions deleted succesfully';
    	}
    }
}
