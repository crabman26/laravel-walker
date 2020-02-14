<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use DataTables;
use Validator;

class CategoriesAjaxController extends Controller
{
    //
    function index(){
    	return view('categories.ajaxdata');
    }

    function getdata(){
    	$categories = Categories::select('id','Title', 'Keyword','Active');
    	return DataTables::of($categories)
    		->addColumn('action', function($category){
                return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$category->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" id="'.$category->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->addColumn('checkbox','<input type="checkbox" name="category_checkbox[]" class="category_checkbox" value="{{$id}}"/>')
            ->rawColumns(['checkbox','action'])
    		->make(true);
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
    			$category = new Categories([
    				'Title' => $request->get('Title'),
    				'Keyword' => $request->get('Keyword'),
    				'Active' => $request->get('Active')
    			]);
    			$category->save();
    			$success_output = '<div class="alert alert-success">Category inserted succesfully.</div>';
    		}
    		if($request->get('button_action') == 'Update')
            {
                $categories = Categories::find($request->get('category_id'));
                $categories->Title = $request->get('Title');
                $categories->Keyword = $request->get('Keyword');
                $categories->Active = $request->get('Active');
                $categories->save();
                $success_output = '<div class="alert alert-success">Category updated succesfully.</div>';
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
        $category = Categories::find($id);
        $output = array(
            'Title'    =>  $category->Title,
            'Keyword'     =>  $category->Keyword,
            'Active'     =>  $category->Active
        );
        echo json_encode($output);
    }

    function removedata(Request $request){
        $category = Categories::find($request->input('id'));
        if ($category->delete()){
            echo "Category deleted succesfully.";
        }
    }

    function massremove(Request $request){
        $categories_id_array = $request->input('id');
        $categories = Categories::whereIn('id',$categories_id_array);
        if ($categories->delete()){
            echo "Categories deleted succesfully";
        }
    }
}
