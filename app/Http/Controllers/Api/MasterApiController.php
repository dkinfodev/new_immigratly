<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserWithProfessional;
use App\Models\DomainDetails;

class MasterApiController extends Controller
{
	var $subdomain
    public function __construct(Request $request)
    {
    	$headers = $request->header();
        $this->subdomain = $headers['subdomain'][0];
        $this->middleware('curl_api');
    }
    public function createClient(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);
            $password = "demo@123";
            $user = $postData['data'];

            $checkExists = User::where("email",$user['email'])->first();
            if(!empty($checkExists)){
            	$response['status'] = 'error';
            	$response['error'] = "email_exists";
            	$response['message'] = "User with email already exists";
        		return response()->json($response);
            }

            $checkExists = User::where("phone_no",$user['phone_no'])->first();
            if(!empty($checkExists)){
            	$response['status'] = 'error';
            	$response['error'] = "phone_exists";
            	$response['message'] = "Phone no already exists";
            	return response()->json($response);
            }

	       	$object = new User();
	        $object->first_name = $user['first_name'];
	        $object->last_name = $user['last_name'];
	        $object->email =  $user['email'];
	        $object->password = bcrypt($password);
	        $object->country_code = $user['country_code'];
	        $object->phone_no = $user['phone_no'];
	        $object->role = "user";
	        $object->is_active = 1;
	        $object->is_verified = 1;
	        $object->save();

	        $user_id = $object->id;

	        $object2 = new UserWithProfessional();
	        $object2->user_id = $user_id;
	        $object2->professional= $this->subdomain;
	        $object2->status = 0;
	        $object2->save();

	        $response['user_id'] = $user_id;
	        $response['post_data'] = $postData;
	        $response['message'] = "Client has been created successfully";
	        $response['status'] = 'success';
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
