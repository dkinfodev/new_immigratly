<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;
use App\Models\DocumentFolder;
use App\Models\VisaServiceCutoff;
use App\Models\VisaServiceContent;
use App\Models\NocCode;

class VisaServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function visaServices()
    {
        
        $viewData['pageTitle'] = "Visa Services";
        return view(roleFolder().'.visa-services.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {   $search = $request->input("search");
        $records = VisaServices::with('SubServices')
                            ->where('parent_id',0)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("name","LIKE","%".$search."%");
                                }
                            })
                            ->orderBy('id',"desc")
                            ->paginate();

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
        $viewData['main_services'] = VisaServices::where("parent_id",0)->get();
        $viewData['documents'] = DocumentFolder::get();
        return view(roleFolder().'.visa-services.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:visa_services',
            'document_folders'=> 'required'
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
        if($request->input('parent_id')){
            $object->parent_id = $request->input("parent_id");
        }
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->unique_id = randomNumber();
        if($request->input("document_folders")){
            $object->document_folders = implode(",",$request->input("document_folders"));
        }
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
        $viewData['documents'] = DocumentFolder::get();
        $viewData['main_services'] = VisaServices::where("parent_id",0)->get();        
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
        $object->slug = str_slug($request->input("name"));
        if($request->input('parent_id')){
            $object->parent_id = $request->input("parent_id");
        }
        if($request->input("document_folders")){
            $object->document_folders = implode(",",$request->input("document_folders"));
        }
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        VisaServices::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServices::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
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

    public function visaServiceCutoff($visa_service_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Cutoff Points";
        return view(roleFolder().'.visa-service-cutoff.lists',$viewData);
    } 

    public function visaCutoffList($visa_service_id,Request $request)
    {   
        $visa_service_id = base64_decode($visa_service_id);
        $records = VisaServiceCutoff::where("visa_service_id",$visa_service_id)
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.visa-service-cutoff.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addCutoff($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $noc_codes = NocCode::get();
        $viewData['noc_codes'] = $noc_codes;
        $viewData['visa_service'] = $visa_service;

        $viewData['pageTitle'] = "Add Cutoff";
        
        return view(roleFolder().'.visa-service-cutoff.add',$viewData);
    }

    public function saveCutoff($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'cutoff_date' => 'required',
            'cutoff_point'=> 'required'
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
        $object =  new VisaServiceCutoff();
        $object->visa_service_id = $id;
        $object->cutoff_date = $request->input("cutoff_date");
        $object->cutoff_point = $request->input("cutoff_point");
        if($request->input("excluded_noc")){
           $object->excluded_noc = implode(",",$request->input("excluded_noc"));
        }
        if($request->input("included_noc")){
           $object->included_noc = implode(",",$request->input("included_noc"));
        }
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/cutoff/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editCutoff($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = VisaServiceCutoff::find($id);
        $noc_codes = NocCode::get();
        $viewData['noc_codes'] = $noc_codes;
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Cutoff";
        
        return view(roleFolder().'.visa-service-cutoff.edit',$viewData);
    }

    public function updateCutoff($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'cutoff_date' => 'required',
            'cutoff_point'=> 'required'
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
        $object =  VisaServiceCutoff::find($id);
        $object->visa_service_id = $visa_service_id;
        $object->cutoff_date = $request->input("cutoff_date");
        $object->cutoff_point = $request->input("cutoff_point");
        if($request->input("excluded_noc")){
           $object->excluded_noc = implode(",",$request->input("excluded_noc"));
        }else{
            $object->excluded_noc = '';
        }

        if($request->input("included_noc")){
           $object->included_noc = implode(",",$request->input("included_noc"));
        }else{
            $object->included_noc = '';
        }
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/cutoff/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingleCutoff($visa_service_id,$id){
        $id = base64_decode($id);
        VisaServiceCutoff::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultipleCutoff($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceCutoff::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function visaServiceContent($visa_service_id){
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Content";
        return view(roleFolder().'.visa-service-content.lists',$viewData);
    }

    public function visaContentList($visa_service_id,Request $request){   
        $visa_service_id = base64_decode($visa_service_id);
        $records = VisaServiceContent::where("visa_service_id",$visa_service_id)
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.visa-service-content.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addContent($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;

        $viewData['pageTitle'] = "Add Content";
        
        return view(roleFolder().'.visa-service-content.add',$viewData);
    }
     
    public function saveContent($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
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
        $object =  new VisaServiceContent();
        $object->visa_service_id = $id;
        $object->description = $request->input("description");
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/content/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editContent($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = VisaServiceContent::find($id);
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Content";
        
        return view(roleFolder().'.visa-service-content.edit',$viewData);
    }

    public function updateContent($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            //'cutoff_point'=> 'required'
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
        $object =  VisaServiceContent::find($id);
        $object->visa_service_id = $visa_service_id;
        $object->description = $request->input("description");
        
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/content/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

     public function deleteSingleContent($visa_service_id,$id){
        $id = base64_decode($id);
        VisaServiceContent::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    
    public function deleteMultipleContent($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceContent::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
}
