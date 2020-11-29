<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserWithProfessional;
use App\Models\DomainDetails;

class MasterApiController extends Controller
{
	var $subdomain;
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
            	$response['message'] = "Client account with email ".$user['email']." already exists";
        		return response()->json($response);
            }

            $checkExists = User::where("phone_no",$user['phone_no'])->first();
            if(!empty($checkExists)){
            	$response['status'] = 'error';
            	$response['error'] = "phone_exists";
            	$response['message'] = "Phone no already exists";
            	return response()->json($response);
            }
            $unique_id = randomNumber();
	       	$object = new User();
	        $object->first_name = $user['first_name'];
	        $object->last_name = $user['last_name'];
	        $object->email =  $user['email'];
	        $object->password = bcrypt($password);
	        $object->country_code = $user['country_code'];
	        $object->phone_no = $user['phone_no'];
            if(isset($user['date_of_birth'])){
                $object->date_of_birth = $user['date_of_birth'];
            }
            if(isset($user['gender'])){
                $object->gender = $user['gender'];
            }
            if(isset($user['country_id'])){
                $object->country_id = $user['country_id'];
            }
            if(isset($user['state_id'])){
                $object->state_id = $user['state_id'];
            }
            if(isset($user['city_id'])){
                $object->city_id = $user['city_id'];
            }
            if(isset($user['address'])){
                $object->address = $user['address'];
            }
            if(isset($user['zip_code'])){
                $object->zip_code = $user['zip_code'];
            }
	        $object->role = "user";
            $object->unique_id = $unique_id;
	        $object->is_active = 1;
	        $object->is_verified = 1;
	        $object->save();

	        $user_id = $object->id;

	        $object2 = new UserWithProfessional();
	        $object2->user_id = $unique_id;
	        $object2->professional= $this->subdomain;
	        $object2->status = 1;
	        $object2->save();

	        $response['user_id'] = $unique_id;
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
