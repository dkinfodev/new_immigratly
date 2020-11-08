<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\QuickLead;
use App\Models\VisaServices;
use App\Models\Countries;

class QuickLeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = QuickLead::count();
        $viewData['countries'] = Countries::get();
        $viewData['visaService'] = visaServices::get();
        $viewData['pageTitle'] = "Quick Lead";
        return view(roleFolder().'.quick-lead.list',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $records = QuickLead::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.quick-lead.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Language";
        return view(roleFolder().'.quick-lead.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
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
        $object =  new QuickLead;
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->phone_no = $request->input("phone_no");
        $object->visa_service = $request->input("visa_service");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('quick-lead');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = QuickLead::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Language";
        return view(roleFolder().'.quick-lead.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  QuickLead::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/quick-lead');
        $response['message'] = "Record updated successfully";

        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        QuickLead::where("id",$id)->delete();
        return redirect()->back()->with("error","Record delete successfully");
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = QuickLead::where("first_name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.quick-lead.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
