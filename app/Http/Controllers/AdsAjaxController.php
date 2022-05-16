<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use DataTables;
use Validator;
use DB;

class AdsAjaxController extends Controller
{
    //
    function index(){
        return view('ads.ajaxdata');
    }

    function adslist(Request $request){
        $ads = DB::table('ads')
           ->join('categories','categories.id','=','ads.catid')
            ->select('ads.id','categories.Title','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
            ->where('categories.Title',$request->category)
           ->paginate(15);

        return view('main.ads',compact('ads'));
    }



    function getdata(Request $request){
        if (request()->ajax()){
            if ($request->category){
                if ($request->state){
                    $ads = DB::table('ads')
                        ->join('categories','categories.id','=','ads.catid')
                        ->select('ads.id','categories.Title','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
                        ->where('categories.Title',$request->category)
                        ->where('State',$request->state);
                } else {
                    $ads = DB::table('ads')
                        ->join('categories','categories.id','=','ads.catid')
                        ->select('ads.id','categories.Title','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
                        ->where('categories.Title',$request->category);
                }
            } else if ($request->region){
                $ads = DB::table('ads')
                    ->select('ads.id','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
                    ->where('Region',$request->region);
            }else if ($request->municipality){
                $ads = DB::table('ads')
                    ->select('ads.id','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
                    ->where('Municipality',$request->municipality);
            }else if($request->state){
                $ads = DB::table('ads')
                    ->select('ads.id','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description')
                    ->where('State',$request->state);
            }else {
                $ads = DB::table('ads')
                    ->join('categories','categories.id','=','ads.catid')
                    ->select('ads.id','categories.Title','ads.Header','ads.Name','ads.Surname','ads.Town','ads.Email','ads.Description','ads.State');
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
    		'Title' => 'required',
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
    			$ad = new Ad([
                    'catid' => $category,
    				'Header' => $request->get('Title'),
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
                $ad = Ad::find($request->get('ads_id'));
                $ad->catid = $category;
                $ad->Header = $request->get('Title');
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
        $ad = Ad::find($id);
        $title = DB::table('categories')
            ->where('id',$ad->catid)->value('Title');
        $output = array(
            'Title'    =>  $ad->Header,
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
        $ad = Ad::find($id);
        if ($ad->delete()){
            echo 'Η αγγελία διαγράφηκε επιτυχώς.';
        }
    }

    function massremove(Request $request){
        $ads_id_array = $request->input('id');
        $ad = Ad::whereIn('id', $ads_id_array);
        if ($ad->delete()){
            echo 'Οι αγγελίες διαγράφηκαν επιτυχώς.';
        } 
    }



}
