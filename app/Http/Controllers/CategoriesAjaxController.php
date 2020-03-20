<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DataTables;
use Validator;
use DB;

class CategoriesAjaxController extends Controller
{
    //
    function index(){
    	return view('categories.ajaxdata');
    }

    function categories(){
        $categories = DB::table('categories')
                    ->orderByRaw('title ASC')
                    ->get();
        return view('main.index',compact('categories'));
    }

    function getdata(Request $request){
        if(request()->ajax()){
            if ($request->active){
                $categories = DB::table('categories')
                    ->select('id','Title', 'Keyword')
                    ->where('Active',$request->active);
            } else {
    	       $categories = Category::select('id','Title', 'Keyword');
            }   
        	return DataTables::of($categories)
        		->addColumn('action', function($category){
                    return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$category->id.'"><i class="glyphicon glyphicon-edit"></i> Επεξεργασία</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$category->id.'"><i class="glyphicon glyphicon-remove"></i> Διαγραφή</a>';
                })
                ->addColumn('checkbox','<input type="checkbox" name="category_checkbox[]" class="category_checkbox" value="{{$id}}"/>')
                ->rawColumns(['checkbox','action'])
        		->make(true);
        }
    }

    function postdata(Request $request){
    	$validation = Validator::make($request->all(),
    		[
    			'Title' => 'required',
    			'Keyword' => 'required',
    			'Active' => 'required',
			]);
    	$error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach ($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages; 
            }
    	} else {
    		if($request->get('button_action') == "Insert"){
    			$category = new Category([
    				'Title' => $request->get('Title'),
    				'Keyword' => $request->get('Keyword'),
    				'Active' => $request->get('Active')
    			]);
    			$category->save();
    			$success_output = '<div class="alert alert-success">Η κατηγορία προστέθηκε επιτυχώς.</div>';
    		}
    		if($request->get('button_action') == 'Update')
            {
                $categories = Category::find($request->get('category_id'));
                $categories->Title = $request->get('Title');
                $categories->Keyword = $request->get('Keyword');
                $categories->Active = $request->get('Active');
                $categories->save();
                $success_output = '<div class="alert alert-success">Η κατηγορία επεξεργάσθηκε επιτυχώς.</div>';
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
        $category = Category::find($id);
        $output = array(
            'Title'    =>  $category->Title,
            'Keyword'     =>  $category->Keyword,
            'Active'     =>  $category->Active
        );
        echo json_encode($output);
    }

    function removedata(Request $request){
        $category = Category::find($request->input('id'));
        if ($category->delete()){
            echo "Η κατηγορία διαγράφηκε επιτυχώς.";
        }
    }

    function massremove(Request $request){
        $categories_id_array = $request->input('id');
        $categories = Category::whereIn('id',$categories_id_array);
        if ($categories->delete()){
            echo "Οι κατηγορίες διαγράφηκαν επιτυχώς.";
        }
    }

    function getcategories(){
        $categorieslist = DB::table('categories')
            ->groupBy('Title')
            ->get();

        echo json_encode($categorieslist);
    }

}
