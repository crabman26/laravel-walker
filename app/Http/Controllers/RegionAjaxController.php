<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Region;
use Validator;
use DB;

class RegionAjaxController extends Controller
{
    //
    function index(){
    	return view('regions.index');
    }

    function getdata(){
    	$regions = Region::select('id','Title');
    	return DataTables::of($regions)
    	->addcolumn('action',function($region){
    		 return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$region->id.'"><i class="glyphicon glyphicon-edit"></i> Επεξεργασία</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$region->id.'"><i class="glyphicon glyphicon-remove"></i> Διαγραφή</a>';
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
	    		$region = new Region([
	    			'Title' => $request->get('Name')
	    		]);
	    		$region->save();
	    		$success_output = '<div class="alert alert-success">Η περιφέρεια προστέθηκε επιτυχώς.</div>';
    		} if ($request->get('button_action') == "Update"){
    			$region = Region::find($request->get('region_id'));
    			$region->Title = $request->get('Name');
    			$region->save();
    			$success_output = '<div class="alert alert-success">Τα στοιχεία για την περιφέρεια επεξεργάσθηκαν επιτυχώς.</div>';
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
    	$region = Region::find($id);
    	$output = array(
    		'Name' => $region->Title
    	);

    	echo json_encode($output);
    }

    function removedata(Request $request){
    	$id = $request->input('id');
    	$region = Region::find($id);
    	if ($region->delete()){
    		echo 'Η περιφέρεια διαγράφηκε επιτυχώς.';
    	}
    }

    function massremove(Request $request){
    	$region_id_array = $request->input('id');
    	$region = Region::WhereIn('id',$region_id_array);
    	if ($region->delete()){
    		echo 'Οι περιφέρειες διαγράφηκαν επιτυχώς.';
    	}
    }

    function getregionlist(){
        $region_list = DB::table('regions')
         ->groupBy('Title')
         ->get();
        echo json_encode($region_list);
    }
}
