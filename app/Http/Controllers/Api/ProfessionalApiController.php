<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\DomainDetails;

class ProfessionalApiController extends Controller
{
    public function __construct()
    {
    	$headers = $request->header();
        $subdomain = $headers['subdomain'][0];
        $this->middleware('curl_api');
        \Config::set('database.connections.mysql.database','immigrat_immigratly_'.$subdomain);
    }
    public function registerProfessional(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);

	       	$object = new User();
	        $object->first_name = $request->input("first_name");
	        $object->last_name = $request->input("last_name");
	        $object->email = $request->input("email");
	        $object->password = bcrypt($request->input("password"));
	        $object->country_code = $request->input("country_code");
	        $object->phone_no = $request->input("phone_no");
	        $object->role = "admin";
	        $object->is_active = 1;
	        $object->is_verified = 1;
	        $object->save();
	        $user_id = $object->id;

	        $object2 = new DomainDetails();
	        $object2->subdomain = $request->input("subdomain");
	        $object2->client_secret = $request->input("client_secret");
	        $object2->master_id = $request->input("master_id");

	        $response['user_id'] = $user_id;
	        $response['status'] = 'success';
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
