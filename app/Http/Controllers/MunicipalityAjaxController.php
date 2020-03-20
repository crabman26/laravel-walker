<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipaly;
use Validator;
use DB;
use DataTables;

class MunicipalityAjaxController extends Controller
{
    //
    function index(){
    	return view('municipalities.index');
    }

    function getdata(Request $request){
        if (request()->ajax()){
            if ($request->region){
                $municipalities = DB::table('municipalities')
                    ->join('regions','regions.id','=','municipalities.regionid')
                    ->select('municipalities.id','regions.Title','municipalities.Name')
                    ->where('regions.Title',$request->region);
            } else {
    	       $municipalities = DB::table('municipalities')
                    ->join('regions','regions.id','=','municipalities.regionid')
                    ->select('municipalities.id','regions.Title','municipalities.Name');
            }
    	return DataTables::of($municipalities)
    	    ->addColumn('action',function($municipality){
    	    	return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$municipality->id.'"><i class="glyphicon glyphicon-edit"></i> Επεξεργασία</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$municipality->id.'"><i class="glyphicon glyphicon-remove"></i> Διαγραφή</a>';
    	    })
    	    ->addColumn('checkbox', '<input type="checkbox" name="municipality_checkbox[]" class="municipality_checkbox" value="{{$id}}" />')
    	    ->rawColumns(['action','checkbox'])
    		->make(true);
        }

    }

    function postdata(Request $request){

    	$validation = Validator::make($request->all(),[
    		'Name' => 'required',
            'Region' => 'required'
    	]);
    	$error_array = array();
    	$success_output = '';
    	if ($validation->fails()){
    		foreach($validation->messages->getmessages() as $field_name => $messages){
    			$error_array = $messages;
    		}
    	} else {
            $title = $request->get('Region');
            $regionid = DB::table('regions')->where('Title',$title)->value('id');
    		if ($request->get('button_action') == "Insert"){
	    		$municipalities = new Municipality([
                    'regionid' => $regionid,
	    			'Name' => $request->get('Name'),
	    		]);
	    		$municipalities->save();
	    		$success_output = '<div class="alert alert-success">Ο δήμος προστέθηκε επιτυχώς.</div>';
    		}

    		if ($request->get('button_action') == "Update"){
    			$municipality = Municipality::find($request->get('municipality_id'));
                $municipality->regionid = $regionid;
    			$municipality->name = $request->get('Name');
    			$municipality->save();
    			$success_output = '<div class="alert alert-success">Τα στοιχεία του δήμου επεξεργάσθηκαν επιτυχώς.</div>';
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
    	$municipality = Municipality::find($id);
        $title = DB::table('regions')->where('id',$municipality->regionid)->value('Title');
    	$output = array(
            'Region' => $title,
    		'Name' => $municipality->Name
    	);
    	echo json_encode($output);
    }

    function removedata(Request $request){
    	$id = $request->input('id');
    	$municipality = Municipality::find($id);
    	if ($municipality->delete()){
    		echo 'Ο δήμος διεγράφη επιτυχώς.';
    	}
    }

    function massremove(Request $request){
    	$municipality_id_array = $request->input('id');
    	$municipalities = Municipality::WhereIn('id',$municipality_id_array);
    	if ($municipalities->delete()){
    		echo 'Οι δήμοι διεγράφησαν επιτυχώς.';
    	} 
    }

    function getmunicipalities(){
        $municipalities = DB::table('municipalities')
                ->groupBy('Name')
                ->get();

        echo json_encode($municipalities);
    }

    function getregionmunicipality(Request $request){
        $title = $request->get('region');
        $regionid = DB::table('regions')->where('Title',$title)->value('id');
        $municipalities = DB::table('municipalities')->where('regionid',$regionid)->groupBy('Name')->get();
        echo json_encode($municipalities);

    }
}
