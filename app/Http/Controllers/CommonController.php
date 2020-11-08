<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CommonController extends Controller
{
   	public function __construct()
    {

    }

    public function stateList(Request $request){
    	$country_id = $request->input("country_id");
    	$states = DB::table(MAIN_DATABASE.".states")->where("country_id",$country_id)->get();
    	$options = '<option value="">Select State</option>';
    	foreach($states as $state){
    		$options .= '<option value="'.$state->id.'">'.$state->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }

    public function cityList(Request $request){
    	$state_id = $request->input("state_id");
    	$cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$state_id)->get();
    	$options = '<option value="">Select City</option>';
    	foreach($cities as $city){
    		$options .= '<option value="'.$city->id.'">'.$city->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }

    public function licenceBodies(Request $request){
    	$country_id = $request->input("country_id");
    	$licence_bodies = DB::table(MAIN_DATABASE.".licence_bodies")->where("country_id",$country_id)->get();
    	$options = '<option value="">Select License Body</option>';
    	foreach($licence_bodies as $bodies){
    		$options .= '<option value="'.$bodies->id.'">'.$bodies->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }
}
