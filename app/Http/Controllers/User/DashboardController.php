<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\Languages;
use App\Models\Notifications;
use App\Models\LanguageProficiency;
use App\Models\ClientExperience;
use App\Models\ClientEducations;
use App\Models\PrimaryDegree;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function dashboard()
    {
        $viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }
    public function editProfile(Request $request){

        $id = \Auth::user()->id;

        $viewData['pageTitle'] = "Edit Profile";
        $record = User::where("id",$id)->first();
        $record2 = UserDetails::where("user_id",$record->unique_id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;

        if(!empty($record2))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record2->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record2->state_id)->get();
            $viewData['cities'] = $cities;
        }


        $languages = Languages::get();
        $viewData['languages'] = $languages;

        $viewData['countries'] = $countries;
        
        $viewData['record'] = $record;
        $viewData['record2'] = $record2;

        return view(roleFolder().'.edit-profile',$viewData);
    }
    
    public function updateProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $username = $object->name;
        $object2 = UserDetails::where('user_id',$object->unique_id)->first();

        if(empty($object2))
        {
            $object2 = new UserDetails();
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
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
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = userDir()."/profile";
            
            $destinationPath = $path.'/thumb';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 100,100,80);

            $destinationPath = $path.'/medium';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 500,500,80);
            $destinationPath = userDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }

        $object2->user_id = \Auth::user()->unique_id;
        $object2->date_of_birth = $request->input("date_of_birth");
        $object2->gender = $request->input("gender");
        $object2->country_id = $request->input("country_id");
        $object2->state_id = $request->input("state_id");
        $object2->city_id = $request->input("city_id");
        $object2->address = $request->input("address");
        $object2->zip_code = $request->input("zip_code");
        $object2->languages_known = json_encode($request->input("languages_known"));

        $object->save();
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/edit-profile');
        $response['message'] = "Profile updated sucessfully";
        
        return response()->json($response);
    }

    public function changePassword()
    {
        $id = \Auth::user()->id;
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Change Password";
        return view(roleFolder().'.change-password',$viewData);
    }

    public function updatePassword(Request $request)
    {
        $id = \Auth::user()->id;
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
        $response['redirect_back'] = baseUrl('edit-profile');
        $response['message'] = "Password updated sucessfully";
        
        return response()->json($response);
    }

    public function notifications(){
        $viewData['pageTitle'] = "All Notifications";

        if(\Session::get("login_to") == 'professional_panel'){
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->orderBy("id","desc")
                        ->get();
        }else{
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }
        $viewData['chat_notifications'] = $chat_notifications;
        $viewData['other_notifications'] = $other_notifications;
        return view(roleFolder().'.allnotification',$viewData);        
    }

    public function manageCv(){
        $user = User::where("id",\Auth::user()->id)->first();
        $user_detail = UserDetails::where("user_id",$user->unique_id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;

        if(!empty($user_detail))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$user_detail->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$user_detail->state_id)->get();
            $viewData['cities'] = $cities;
        }
        $languages = Languages::get();
        $language_proficiency = LanguageProficiency::where("user_id",\Auth::user()->unique_id)->first();

        $work_expirences = ClientExperience::where("user_id",\Auth::user()->unique_id)->orderBy('id','desc')->get();
        $educations = ClientEducations::where("user_id",\Auth::user()->unique_id)->orderBy('id','desc')->get();
        $viewData['languages'] = $languages;
        $viewData['work_expirences'] = $work_expirences;
        $viewData['educations'] = $educations;
        $viewData['language_proficiency'] = $language_proficiency;
        $viewData['countries'] = $countries;
        $viewData['pageTitle'] = "Manage CV";
        $viewData['user'] = $user;
        $viewData['user_detail'] = $user_detail;
        return view(roleFolder().'.manage-cv',$viewData);        
    }


    public function addWorkExperience(Request $request){
       
        $viewData['pageTitle'] = "Add Work Experience";
        $view = View::make(roleFolder().'.modal.add-work-experience',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveWorkExperience(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'employment_agency' => 'required',
                'position' => 'required',
                'join_date' => 'required',
                'leave_date' => 'required',
                'exp_details' => 'required',
                'job_type' => 'required',
                'noc_code' => 'required',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }

            $object = new ClientExperience();
            $object->employment_agency = $request->input("employment_agency");
            $object->user_id = \Auth::user()->unique_id;
            $object->position = $request->input("position");
            $object->join_date = $request->input("join_date");
            $object->leave_date = $request->input("leave_date");
            $object->exp_details = $request->input("exp_details");
            $object->job_type = $request->input("job_type");
            $object->noc_code = $request->input("noc_code");
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function editWorkExperience($id){
       
        $id = base64_decode($id);
        $record = ClientExperience::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Work Experience";
        $view = View::make(roleFolder().'.modal.edit-work-experience',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateWorkExperience($id,Request $request){
        try{
            $id = base64_decode($id);
            $validator = Validator::make($request->all(), [
                'employment_agency' => 'required',
                'position' => 'required',
                'join_date' => 'required',
                'leave_date' => 'required',
                'exp_details' => 'required',
                'job_type' => 'required',
                'noc_code' => 'required',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }

            $object = ClientExperience::find($id);
            $object->employment_agency = $request->input("employment_agency");
            $object->user_id = \Auth::user()->unique_id;
            $object->position = $request->input("position");
            $object->join_date = $request->input("join_date");
            $object->leave_date = $request->input("leave_date");
            $object->exp_details = $request->input("exp_details");
            $object->job_type = $request->input("job_type");
            $object->noc_code = $request->input("noc_code");
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteExperience($id){
        $id = base64_decode($id);
        ClientExperience::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }

    public function educations(Request $request){
        $viewData['pageTitle'] = "Educations";
        
        $view = View::make(roleFolder().'.educations',$viewData);
        $contents = $view->render();
    }

    public function addEducation(Request $request){
       
        $viewData['pageTitle'] = "Add Education";
        $primary_degree = PrimaryDegree::get();
        $viewData['primary_degree'] = $primary_degree;
        $view = View::make(roleFolder().'.modal.add-education',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveEducation(Request $request){
        try{
            $valid = array(
                'degree_id' => 'required',
                'qualification' => 'required',
                'percentage' => 'required',
                'year_passed' => 'required'
            );
            if($request->input("is_eca") == 1){
                $valid['eca_equalency'] = 'required';
                $valid['eca_doc_no'] = 'required';
                $valid['eca_agency'] = 'required';
                $valid['eca_year'] = 'required';
            }
            $validator = Validator::make($request->all(),$valid);

            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }

            $object = new ClientEducations();
            $object->degree_id = $request->input("degree_id");
            $object->user_id = \Auth::user()->unique_id;
            $object->qualification = $request->input("qualification");
            $object->percentage = $request->input("percentage");
            $object->year_passed = $request->input("year_passed");
            if($request->input("is_eca") == 1){
                $object->is_eca = 1;
                $object->eca_equalency = $request->input("eca_equalency");
                $object->eca_doc_no = $request->input("eca_doc_no");
                $object->eca_agency = $request->input("eca_agency");
                $object->eca_year = $request->input("eca_year");
            }
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function editEducation($id){
       
        $id = base64_decode($id);
        $record = ClientEducations::where("id",$id)->first();
        $viewData['record'] = $record;
        $primary_degree = PrimaryDegree::get();
        $viewData['primary_degree'] = $primary_degree;
        $viewData['pageTitle'] = "Edit Education";
        $view = View::make(roleFolder().'.modal.edit-education',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateEducation($id,Request $request){
        try{
            $id = base64_decode($id);
            $valid = array(
                'degree_id' => 'required',
                'qualification' => 'required',
                'percentage' => 'required',
                'year_passed' => 'required'
            );
            if($request->input("is_eca") == 1){
                $valid['eca_equalency'] = 'required';
                $valid['eca_doc_no'] = 'required';
                $valid['eca_agency'] = 'required';
                $valid['eca_year'] = 'required';
            }
            $validator = Validator::make($request->all(),$valid);


            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $object = ClientEducations::find($id);
            $object->degree_id = $request->input("degree_id");
            $object->user_id = \Auth::user()->unique_id;
            $object->qualification = $request->input("qualification");
            $object->percentage = $request->input("percentage");
            $object->year_passed = $request->input("year_passed");
            if($request->input("is_eca") == 1){
                $object->is_eca = 1;
                $object->eca_equalency = $request->input("eca_equalency");
                $object->eca_doc_no = $request->input("eca_doc_no");
                $object->eca_agency = $request->input("eca_agency");
                $object->eca_year = $request->input("eca_year");
            }else{
                $object->is_eca = 0;
                $object->eca_equalency = '';
                $object->eca_doc_no = '';
                $object->eca_agency = '';
                $object->eca_year = '';
            }
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record updated successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteEducation($id){
        $id = base64_decode($id);
        ClientEducations::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }

    public function saveLanguageProficiency(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'pte' => 'required',
                'tofel' => 'required',
                'ielts' => 'required',
                'gre' => 'required',
                'other' => 'required'
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $language_proficiency = LanguageProficiency::where("user_id",\Auth::user()->unique_id)->first();
            if(!empty($language_proficiency)){
                $object = LanguageProficiency::find($language_proficiency->id);
            }else{
                $object = new LanguageProficiency();
            }
            $object->user_id = \Auth::user()->unique_id;
            $object->pte = $request->input("pte");
            $object->tofel = $request->input("tofel");
            $object->ielts = $request->input("ielts");
            $object->gre = $request->input("gre");
            $object->other = $request->input("other");
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record saved successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function connectApps(){
        $viewData = array();
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['user_detail'] = $user_detail;
        return view(roleFolder().'.connect-apps',$viewData);           
    }

    public function googleAuthention(){
        $url = baseUrl("/connect-apps/connect-google");
        $domain = get_domaininfo(url('/'));
        setcookie("google_url", $url, time() + (86400 * 30), '/');
        $url = google_auth_url();
        return redirect($url);
    }
    public function unlinkApp($app){
        if($app == 'google'){
            $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $object->google_drive_auth = '';
            $object->save();
            return redirect()->back()->with("success","Google drive account unlinked");
        }
        if($app == 'dropbox'){
            $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $object->dropbox_auth = '';
            $object->save();
            return redirect()->back()->with("success","Dropbox account unlinked");
        }
        return redirect()->back();
    }
    public function connectGoogle(Request $request){
        if(isset($_GET['code'])){
            $return = google_callback($_GET['code']);

            if(isset($return['access_token'])){
                $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
                $object->google_drive_auth = json_encode($return);
                $object->save();
                return redirect(baseUrl('/connect-apps'))->with("success","Google account connected successfully");
            }
            return redirect(baseUrl('/connect-apps'))->with("error","Google connection failed try again");
        }else{
            return redirect(baseUrl('/connect-apps'))->with("error","Google connection failed");
        }   
    }

    public function dropboxAuthention(){
        $url = baseUrl("/connect-apps/connect-dropbox");
        $domain = get_domaininfo(url('/'));
        setcookie("dropbox_url", $url, time() + (86400 * 30), '/');
        $url = dropbox_auth_url();
        return redirect($url);
    }

    public function connectDropbox(Request $request){
       
        if(isset($_GET['code'])){
            $return = dropbox_callback($_GET['code']);
            
            if(isset($return['access_token'])){
                $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
                $object->dropbox_auth = json_encode($return);
                $object->save();
                return redirect(baseUrl('/connect-apps'))->with("success","Dropbox account connected successfully");
            }
            return redirect(baseUrl('/connect-apps'))->with("error",$return['message']);
        }else{
            return redirect(baseUrl('/connect-apps'))->with("error","Dropbox connection failed");
        }   
    }
}
