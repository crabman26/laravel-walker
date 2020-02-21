<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ads;
use DataTables;
use Validator;
use DB;

class AdsAjaxController extends Controller
{
    //
    function index(){
        return view('ads.ajaxdata');
    }

    function getdata(Request $request){
        if (request()->ajax()){
            if ($request->category){
                $ads = DB::table('ads')
                    ->join('categories','categories.id','=','ads.catid')
                    ->select('ads.id','categories.Title','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description','ads.State')
                    ->where('categories.Title',$request->category);
            } else if ($request->region){
                $ads = DB::table('ads')
                    ->select('ads.id','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description','ads.State')
                    ->where('Region',$request->region);
            }else if ($request->municipality){
                $ads = DB::table('ads')
                    ->select('ads.id','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description','ads.State')
                    ->where('Municipality',$request->municipality);
            }else {
                $ads = DB::table('ads')
                    ->join('categories','categories.id','=','ads.catid')
                    ->select('ads.id','categories.Title','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description','ads.State');
            }
    	return DataTables::of($ads)
            ->addColumn('action', function($ad){
                return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$ad->id.'"><i class="glyphicon glyphicon-edit"></i> Επεξεργασία</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$ad->id.'"><i class="glyphicon glyphicon-remove"></i> Διαγραφή</a>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="ad_checkbox[]" class="ad_checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
    		->make(true);
        }
    }

    function postdata(Request $request){
    	$validation = Validator::make($request->all(),[
    		'Name' => 'required',
    		'Surname' => 'required',
            'Category' => 'required',
    		'Town' => 'required',
            'Municipality' => 'required',
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
    		$title = $request->get('Category');
            $category = DB::table('categories')
                ->where('Title',$title)->value('id');
            if($request->get('button_action') == "Insert"){
    			$ad = new Ads([
                    'catid' => $category,
    				'Name' => $request->get('Name'),
    				'Surname' => $request->get('Surname'),
    				'Town' => $request->get('Town'),
                    'Municipality' => $request->get('Municipality'),
    				'Region' => $request->get('Region'),
    				'Email' => $request->get('E-mail'),
    				'Description' => $request->get('Description'),
    				'State' => $request->get('State')
    			]);
    			$ad->save();
    			$success_output = '<div class="alert alert-success">Η αγγελία προστέθηκε επιτυχώς.</div>';
    		}
            if($request->get('button_action') == 'Update')
            {
                $ad = Ads::find($request->get('ads_id'));
                $ad->catid = $category;
                $ad->Name = $request->get('Name');
                $ad->Surname = $request->get('Surname');
                $ad->Town = $request->get('Town');
                $ad->Municipality = $request->get('Municipality');
                $ad->Region = $request->get('Region');
                $ad->Email = $request->get('E-mail');
                $ad->Description = $request->get('Description');
                $ad->State = $request->get('State');
                $ad->save();
                $success_output = '<div class="alert alert-success">Η αγγελία επεξεργάστηκε επιτυχώς.</div>';
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
        $title = DB::table('categories')
            ->where('id',$ad->catid)->value('Title');
        $output = array(
            'Name'    =>  $ad->Name,
            'Surname'     =>  $ad->Surname,
            'Category'     =>  $title,
            'Town'     =>  $ad->Town,
            'Municipality'     =>  $ad->Municipality,
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
            echo 'Η αγγελία διαγράφηκε επιτυχώς.';
        }
    }

    function massremove(Request $request){
        $ads_id_array = $request->input('id');
        $ad = Ads::whereIn('id', $ads_id_array);
        if ($ad->delete()){
            echo 'Οι αγγελίες διαγράφηκαν επιτυχώς.';
        } 
    }


}
