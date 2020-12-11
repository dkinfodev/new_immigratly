<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\RolePrivileges;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function profile()
    {
       	$viewData['pageTitle'] = "Profile";
       	$viewData['active_tab'] = "profile_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.profile',$viewData);
    }

    public function services()
    {
       	$viewData['pageTitle'] = "Services";
       	$viewData['active_tab'] = "service_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.services',$viewData);
    }

    public function articles()
    {
        $viewData['pageTitle'] = "Articles";
        $viewData['active_tab'] = "article_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.articles',$viewData);
    }

    public function events()
    {
        $viewData['pageTitle'] = "Events";
        $viewData['active_tab'] = "event_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.events',$viewData);
    }

    public function editProfile()
    {
       	$viewData['pageTitle'] = "Edit Profile";
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.edit-profile',$viewData);
    }

    public function completeProfile()
    {
        $viewData['pageTitle'] = "Complete Profile";
        $viewData['active_tab'] = "personal_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.complete-profile',$viewData);
    }

    public function rolePrivileges()
    {
        $viewData['pageTitle'] = "Role Privileges";
       
        $api_response = curlRequest("roles");
        $roles = array();
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $roles = $api_response['data'];
        }

        $viewData['roles'] = $roles;
        $api_response = curlRequest("privileges");
        $privileges = array();
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $privileges = $api_response['data'];
        }
        $role_privileges = RolePrivileges::get();
        $temp = array();
        foreach($role_privileges as $value){
            $temp[$value->role][$value->module][] = $value->action;
        }
        
        $viewData['role_privileges'] = $temp;
        $viewData['privileges'] = $privileges;
        return view(roleFolder().'.role-privileges',$viewData);
    }

    public function savePrivileges(Request $request){
        
        RolePrivileges::truncate();
        if($request->input("privileges")){
            $privileges = $request->input("privileges");
            foreach($privileges as $role => $values){
                foreach($values as $module => $actions){
                   for($i=0;$i < count($actions);$i++){
                        $object = new RolePrivileges();
                        $object->role = $role;       
                        $object->module = $module;
                        $object->action = $actions[$i];
                        $object->save();
                    }     
                }
            }
            $response['status'] = true;
            $response['message'] = "Privileges added to roles";
        }else{
            $response['status'] = 'error';
            $response['message'] = 'No privileges selected';
        }
        return response()->json($response);
    }
}
