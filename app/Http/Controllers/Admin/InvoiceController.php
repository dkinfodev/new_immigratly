<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\Invoices;
use App\Models\CaseInvoices;
use App\Models\CaseInvoiceItems;
use App\Models\Cases;
use App\Models\ProfessionalDetails;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function caseInvoices($case_id)
    {
        $id = base64_decode($case_id);
        $case = Cases::find($id);
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Case Invoices";
        return view(roleFolder().'.cases.invoices',$viewData);
    } 

    public function getCaseInvoice(Request $request)
    {
        $case_id = $request->input("case_id");
        $records = CaseInvoices::with(['Invoice'])
                        ->where("case_id",$case_id)
                        ->orderBy('id',"desc")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.invoices-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addCaseInvoice($case_id){

        $id = base64_decode($case_id);
        $case = Cases::find($id);
        $client = $case->Client($case->client_id);
        $professional = ProfessionalDetails::first();
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['pageTitle'] = "Add Invoice";
        return view(roleFolder().'.cases.add-invoice',$viewData);
    }


    public function saveCaseInvoice($id,Request $request){
        
        $validator = Validator::make($request->all(), [
            'invoice_date' => 'required',
            'due_date' => 'required',
            'bill_from' => 'required',
            'bill_to'=>'required',
            'items'=>'required',
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
        $case_id = base64_decode($id);
        $case = Cases::find($case_id);
        
        $created_by = \Auth::user()->unique_id;
        
        $items = $request->input("items");
        
        $total_amount = 0;
        foreach($items as $item){
            $total_amount += $item['amount'];
        }
        $inv_unique_id = randomNumber();
        $invObject = new Invoices();
        $invObject->unique_id = $inv_unique_id;
        $invObject->client_id = $case->client_id;
        $invObject->amount = $total_amount;
        $invObject->payment_status = 'pending';
        $invObject->link_to = "case";
        $invObject->link_id = $case->unique_id;
        $invObject->bill_from = $request->input("bill_from");
        $invObject->bill_to = $request->input("bill_to");
        $invObject->invoice_date = $request->input("invoice_date");
        $invObject->due_date = $request->input("due_date");
        $invObject->created_by = $created_by;
        $invObject->save();

        $cinv_unique_id = randomNumber();
        $caseInvObj = new CaseInvoices();
        $caseInvObj->unique_id = $cinv_unique_id;
        $caseInvObj->case_id = $case->unique_id;
        $caseInvObj->invoice_id = $inv_unique_id;
        if($request->input("notes")){
            $caseInvObj->notes = $request->input("notes");
        }
        $caseInvObj->total_amount = $total_amount;
        $caseInvObj->save();

        foreach($items as $item){
            $itemObj = new CaseInvoiceItems();
            $itemObj->case_id = $case->unique_id;
            $itemObj->case_invoice_id = $cinv_unique_id;
            $itemObj->particular = $item["particular_name"];
            $itemObj->amount = $item["amount"];
            $itemObj->save();
        }

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('cases/invoices/list/'.base64_encode($case->id));
        $response['message'] = "Invoice added sucessfully";
        
        return response()->json($response);
    }
 
    public function editCaseInvoice($invoice_id){
        $id = base64_decode($invoice_id);
        $invoice = CaseInvoices::with(["Invoice","InvoiceItems"])->first();
        $case_id = $invoice->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        $client = $case->Client($case->client_id);
        $professional = ProfessionalDetails::first();
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['record'] = $invoice;
        $viewData['pageTitle'] = "Edit Invoice";
        return view(roleFolder().'.cases.edit-invoice',$viewData);
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
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'role'=>'required',
            'profile_image'=>'mimes:jpeg,jpg,png,gif'
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
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        
        $object->role = $request->input("role");
        $path = professionalDir()."/profile";
        $object->languages_known = json_encode($request->input("languages_known"));
        if($object->profile_image !=''){
            if(file_exists($path.'/'.$object->profile_image))
                unlink($path.'/'.$object->profile_image);

            if(file_exists($path.'/thumb/'.$object->profile_image))
                unlink($path.'/thumb/'.$object->profile_image);

            if(file_exists($path.'/medium/'.$object->profile_image))
                unlink($path.'/medium/'.$object->profile_image);
        }
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            // Thumb Image
            
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

            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->is_active = 1;
        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('staff');
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
        return view(roleFolder().'.invoices.change-password',$viewData);
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
        $response['redirect_back'] = baseUrl('staff');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

}
