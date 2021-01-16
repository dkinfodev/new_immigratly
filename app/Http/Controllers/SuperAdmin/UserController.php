<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\User;
use App\Models\Countries;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Users";
        return view(roleFolder().'.user.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = User::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                            }
                        })
                        ->where("role","user")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.user.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    
    public function add(){
        $viewData['pageTitle'] = "Add User";
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.user.add',$viewData);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no',
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
        ]);

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
        
        $object = new User();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->is_active = $request->input("status");

        $object->role = 'user';

        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = UserDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }
        
        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;
        $object->social_connect = 0;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('user');
        $response['message'] = "User added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit User";
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
       
        $countries = Countries::get();
        $viewData['countries'] = $countries;
    
        return view(roleFolder().'.user.edit',$viewData);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
        ]);

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
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->is_active = $request->input("status");        
        
        $object->role = 'user';
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = UserDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;
        $object->social_connect = 0;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('user');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        User::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            User::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


    public function changePassword($id)
    {
        $id = base64_decode($id);
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Change Password";
        return view(roleFolder().'.user.change-password',$viewData);
    }

    public function updatePassword($id,Request $request)
    {
        $id = base64_decode($id);
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
        ]);

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
        
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('user');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }
}
