<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Redirect;

use App\Models\User;
use App\Models\Countries;


class DashboardController extends Controller
{
	var $dropdown;
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function dashboard()
    {
        $viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function editProfile()
    {
        $viewData['pageTitle'] = "Edit Profile";
        
        $countries = Countries::get();
        $viewData['countries'] = $countries;

        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.edit-profile',$viewData);
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:6',
            'country_code' => 'required',
            'phone_no' => 'required',
            // 'verification_code'=>'required',
        ]);
        
       // session(['redirect_back' => $request->input('redirect_back')]);
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        

        $id = \Auth::user()->id;
        $user = User::find($id);
        
        $object =  User::find($id);
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }
        $object->phone_no = $request->input("phone_no");
        $object->country_code = $request->input("country_code");
        $object->save();
        return redirect()->back();

    }
}
