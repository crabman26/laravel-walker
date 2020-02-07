<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use DataTables;

class CategoriesAjaxController extends Controller
{
    //
    function index(){
    	return view('categories.ajaxdata');
    }

    function getdata(){
    	$categories = Categories::select('Title', 'Keyword','Active');
    	return DataTables::of($categories)->make(true);
    }
}
