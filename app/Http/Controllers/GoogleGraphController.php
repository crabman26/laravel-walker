<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class GoogleGraphController extends Controller
{
    //
    function index(){

    	$categorydata = DB::table('ads')
    		->join('categories','ads.catid','=','categories.id')
    		->select(
    			DB::raw('categories.Title as Category'),
    			DB::raw('count(*) as Number')
    		)
    		->groupBy('categories.Title')
    		->get();

    	$categories[] = ['Category','Number'];

    	foreach($categorydata as $key => $value){
    		$categories[++$key] = [$value->Category, $value->Number];
    	}

    	$municipalitydata = DB::table('ads')
    			->select(
    				DB::raw('Municipality as Municipality'),
    				DB::raw('count(*) as Number')
    			)
    			->groupBy('Municipality')
    			->get();

    	$municipalities[] = ['Municipality','Number'];

    	foreach($municipalitydata as $key => $value){
    		$municipalities[++$key] = [$value->Municipality, $value->Number];
    	}

    	$regiondata = DB::table('ads')
    			->select(
    				DB::raw('Region as Region'),
    				DB::raw('count(*) as Number')
    			)
    			->groupBy('Region')
    			->get();

    	$regions[] = ['Region','Number'];

    	foreach($regiondata as $key => $value){
    		$regions[++$key] = [$value->Region, $value->Number];
    	}

    	$statedata = DB::table('ads')
    			->select(
    				DB::raw('State as State'),
    				DB::raw('count(*) as Number')
    			)
    			->groupBy('state')
    			->get();

    	$states[] = ['State','Number'];

    	foreach($statedata as $key => $value){
    		$states[++$key] = [$value->State, $value->Number];
    	}

    	return view('stats.adchart')
    			->with('Category',json_encode($categories))
    			->with('Municipality',json_encode($municipalities))
    			->with('Region',json_encode($regions))
    			->with('State',json_encode($states)); 


    }
}
