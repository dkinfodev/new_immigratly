<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\ProfessionalModules;
use App\Models\ModulesAction;

class ModulesActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index($id)
    {
        $id = base64_decode($id);    
        $viewData['total_bodies'] = ModulesAction::where('id',$id)->count();
        $viewData['moduleId'] = $id;

        $moduleName = ProfessionalModules::where('id',$id)->first();
        $viewData['moduleName'] = $moduleName->name;

        $viewData['pageTitle'] = "Modules Action";
        return view(roleFolder().'.modules-action.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $id = $request->input('id');
        $id = base64_decode($id);
        //$id = 3;
        $records = ModulesAction::where('module_id',$id)->orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.modules-action.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Professional Modules";
        return view(roleFolder().'.modules-action.add',$viewData);
    }


    public function save(Request $request){
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
        $object =  new ProfessionalModules;
        $object->name = $request->input("name");
        $object->slug = $request->input("name");
        //$object->module_action = $request->input("module_action");
        //$object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('professional-modules');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = ProfessionalModules::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Professional Modules";
        return view(roleFolder().'.modules-action.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  ProfessionalModules::find($id);
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

        $object->name = $request->input("name");
        //$object->module_action = $request->input("module_action");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/professional-modules');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        ProfessionalModules::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ProfessionalModules::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function search($keyword){
        $keyword = $keyword;
        
        $records = ProfessionalModules::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.modules-action.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
