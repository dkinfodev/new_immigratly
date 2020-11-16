<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;
use App\Models\Leads;
use App\Models\User;
use App\Models\CaseTeams;

class CasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function cases(Request $request){
        $viewData['pageTitle'] = "Cases";
        return view(roleFolder().'.cases.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = Cases::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("case_title","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function createClient(Request $request){
       
        $viewData['pageTitle'] = "Create Client";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.cases.modal.new-client',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function createNewClient(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_code' => 'required',
            'phone_no' => 'required',
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
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = $request->input('email');
        $data['country_code'] = $request->input('country_code');
        $data['phone_no'] = $request->input('phone_no');
        $postData['data'] = $data;
        $result = curlRequest("create-client",$postData);
       
        if($result['status'] == 'error'){
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = $result['message'];
        }elseif($result['status'] == 'success'){
            $clients = User::ProfessionalClients(\Session::get("subdomain"));
            $options = '<option value="">Select Client</option>';
            foreach($clients as $client){
                $options .='<option '.($client->email == $request->input('email'))?'selected':''.' value="'.$client->unique_id.'">'.$client->first_name.' '.$client->last_name.'</option>';
            }
            $response['status'] = true;
            $response['options'] = $options;
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Issue while creating client";
        }
        return response()->json($response);
    }
    public function add(){
        $viewData['pageTitle'] = "Create Case";
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        return view(roleFolder().'.cases.add',$viewData);
    } 
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
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

        $object = new Cases();
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->id;
        $object->save();

        $case_id = $object->id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            for($i=0;$i < count($assign_teams);$i++){
                $object2 = new CaseTeams();
                $object2->user_id = $assign_teams[$i];
                $object2->case_id = $case_id;
                $object2->save();
            }
        }
        $response['status'] = true;
        $response['message'] = "Case created successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }
    public function deleteSingle($id){
        $id = base64_decode($id);
        Cases::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Cases::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }



    public function edit($id){
        $id = base64_decode($id);
        $record = Cases::with('AssingedMember')->find($id);
        $assignedMember = $record->AssingedMember;
        $viewData['record'] = $record;
        $viewData['assignedMember'] = $assignedMember;
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        $viewData['pageTitle'] = "Edit Case";
        return view(roleFolder().'.cases.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
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

        $object = Cases::find($id);
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->id;
        $object->save();

        $case_id = $object->id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            $checkRemoved = CaseTeams::whereNotIn("user_id",$assign_teams)->where("case_id",$case_id)->get();
            if(!empty($checkRemoved)){
                foreach($checkRemoved as $rec){
                    CaseTeams::deleteRecord($rec->id);
                }
            }
            for($i=0;$i < count($assign_teams);$i++){
                $checkExists = CaseTeams::where("user_id",$assign_teams[$i])->where("case_id",$case_id)->count();
                if($checkExists == 0){
                    $object2 = new CaseTeams();
                    $object2->user_id = $assign_teams[$i];
                    $object2->case_id = $case_id;
                    $object2->save();
                }
            }
        }
        $response['status'] = true;
        $response['message'] = "Case edited successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }

    public function caseDocuments($id){
        $id = base64_decode($id);
        $record = Cases::find($id);
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['pageTitle'] = "Documents";

        return view(roleFolder().'.cases.document-folders',$viewData);
    }

    public function documentFiles($id){
        $id = base64_decode($id);
        $record = Cases::find($id);
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['pageTitle'] = "Documents";

        return view(roleFolder().'.cases.document-files',$viewData);
    }
}
