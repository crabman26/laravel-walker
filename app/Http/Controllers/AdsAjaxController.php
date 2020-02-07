<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ads;
use DataTables;

class AdsAjaxController extends Controller
{
    //
    function index(){
    	return view('ads.ajaxdata');
    }

    function getdata(){
    	$ads = Ads::select('Name','Surname','Town','Region','Email','Description','State');
    	return DataTables::of($ads)->make(true);
    }
}
