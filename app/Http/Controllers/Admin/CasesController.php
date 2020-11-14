<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\Leads;
use App\Models\User;

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
                                $query->where("first_name","LIKE","%$search%");
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

    public function createClientCase($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Create Case";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.leads.modal.quick-lead',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
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
    public function add(){
        $viewData['pageTitle'] = "Create Case";
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = Leads::where("mark_as_client","1")->get();
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        return view(roleFolder().'.cases.add',$viewData);
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
        $object->email = $request->input("first_name");
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
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Lead";
        return view(roleFolder().'.leads.edit',$viewData);
    }
}
