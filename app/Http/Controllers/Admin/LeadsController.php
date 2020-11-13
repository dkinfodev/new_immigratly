<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Leads;
use App\Models\ProfessionalServices;
class LeadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function newLeads(Request $request){
    	$viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::count();
        $viewData['assigned_leads'] =  Leads::count();
       	$viewData['pageTitle'] = "New Leads";
        return view(roleFolder().'.leads.lists',$viewData);
    }

    public function getNewList(Request $request)
    {
        $search = $request->input("search");
        $records = Leads::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                                $query->orWhere("last_name","LIKE","%$search%");
                                $query->orWhere("email","LIKE","%$search%");
                                $query->orWhere(DB::raw('concat(country_code,"",phone_no)') , 'LIKE' , "%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.leads.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function quickLead(){
        $viewData['pageTitle'] = "Quick Lead";
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
       
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.leads.modal.quick-lead',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function createQuickLead(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads',
            'country_code' => 'required',
            'phone_no' => 'required|unique:leads',
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

        $object = new Leads();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Lead added successfully";
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Leads::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Leads::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function edit($id){
        $id = base64_decode($id);
        $record = Leads::find($id);
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Lead";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record->state_id)->get();
        $viewData['cities'] = $cities;
        return view(roleFolder().'.leads.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object = Leads::find($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads,email,'.$object->id,
            'country_code' => 'required',
            'phone_no' => 'required|unique:leads,phone_no,'.$object->id,
            'gender' => 'required',
            'date_of_birth' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
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

        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->date_of_birth = $request->input("date_of_birth");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Lead edited successfully";
        $response['redirect_back'] = baseUrl('leads');
        return response()->json($response);
    }

    public function markAsClient($id){
        $viewData['pageTitle'] = "Mark as client";
        $viewData['lead_id'] = base64_decode($id);
        $view = View::make(roleFolder().'.leads.modal.mark-as-client',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }
    
    public function confirmAsClient($id,Request $request){
        $id = base64_decode($id);
        $lead = Leads::select('first_name','last_name','email','country_code','phone_no','date_of_birth','gender','country_id','state_id','city_id','address','zip_code')->where("id",$id)->first();
        $postData['data'] = $lead;
        $result = curlRequest("create-client",$postData);
        if($result['status'] == 'error'){
            $response['status'] = false;
            $response['message'] = $result['message'];
        }elseif($result['status'] == 'success'){
            // $client_id = 
        }

    }

}
