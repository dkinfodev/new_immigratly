<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;

class VisaServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function visaServices()
    {
        $viewData['total_bodies'] = VisaServices::count();
        $viewData['pageTitle'] = "Visa Services";
        return view(roleFolder().'.visa-services.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $records = VisaServices::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.visa-services.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Visa Service";
        return view(roleFolder().'.visa-services.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:visa_services',
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
        $object =  new VisaServices;
        $object->name = $request->input("name");
        $object->slug = Str::slug($request->input("name"),'-');
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = VisaServices::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Visa Services";
        return view(roleFolder().'.visa-services.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object =  VisaServices::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:visa_services,name,'.$object->id,
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

        
        $object->name = $request->input("name");
        $object->slug = Str::slug($request->input("name"),'-');
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        VisaServices::where("id",$id)->delete();
        return redirect()->back();
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = VisaServices::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.visa-services.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
