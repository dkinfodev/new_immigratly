<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;
use App\Models\Assessments;
use App\Models\UserInvoices;
use App\Models\InvoiceItems;
use App\Models\VisaServices;
class AssessmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function index(Request $request){
        $viewData['pageTitle'] = "Assessments";
        return view(roleFolder().'.assessments.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $records = Assessments::orderBy('id',"desc")
                                    ->where("user_id",\Auth::user()->unique_id)
                                    ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.assessments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(Request $request){
        $viewData['pageTitle'] = "Add Assessment";
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.add',$viewData);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'case_name' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            // 'amount_paid' => 'required',
            // 'payment_status' => 'required',
            // 'payment_response' => 'required',
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
        $visa_service = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        $unique_id = randomNumber();
        $object =  new Assessments();
        $object->unique_id = $unique_id;
        $object->case_name = $request->input("case_name");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->case_type = $request->input("case_type");
        $object->user_id = \Auth::user()->unique_id;
        $object->amount_paid = $visa_service->assessment_price;
        // $object->payment_status = $request->input("payment_status");
        // $object->payment_response = $request->input("payment_response");
        $object->save();
        
        $inv_unique_id = randomNumber();
        $object2 = new UserInvoices();
        $object2->unique_id = $inv_unique_id;
        $object2->client_id = \Auth::user()->unique_id;
        $object2->payment_status = "pending";
        $object2->amount = $visa_service->assessment_price;
        $object2->link_to = 'assessment';
        $object2->link_id = $unique_id;
        $object2->invoice_date = date("Y-m-d"); 
        $object2->created_by = \Auth::user()->unique_id;
        $object2->save();

        $object2 = new InvoiceItems();
        $object2->invoice_id = $inv_unique_id;
        $object2->unique_id = randomNumber();
        $object2->particular = "Assessment Fee";
        $object2->amount = $visa_service->assessment_price;
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('assessments/edit/'.$unique_id.'?step=2');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($id,Request $request){
        if($request->get('step')){
            $viewData['active_step'] = $request->get("step");
        }else{
            $viewData['active_step'] = 1;
        }
        $viewData['pageTitle'] = "Edit Assessment";
        $record = Assessments::where("unique_id",$id)->first();
        $pay_amount = $record->amount_paid;
        $invoice_id = $record->Invoice->unique_id;
        $viewData['invoice_id'] = $invoice_id;
        $viewData['pay_amount'] = $pay_amount;
        $viewData['record'] = $record;
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'description' => 'required',
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
        $object =  Assessments::find($id);
        $object->price = $request->input("price");
        $object->description = $request->input("description");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('assessments');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Assessments::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Assessments::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
}
