<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\LeadQualities;

class LeadQualitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = LeadQualities::count();
        $viewData['pageTitle'] = "Lead Qualities";
        return view(roleFolder().'.lead-qualities.list',$viewData);
    } 

    public function getList(Request $request)
    {
        $records = LeadQualities::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.lead-qualities.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Lead Quality";
        return view(roleFolder().'.lead-qualities.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'point' => ['required', 'min:1', 'max:5'],
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
        
        $object =  new LeadQualities;
        $object->name = $request->input("name");
        $object->point = $request->input("point");
        $object->save();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('lead-qualities');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = LeadQualities::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Lead Qualities";
        return view(roleFolder().'.lead-qualities.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object =  LeadQualities::find($id);

     $validator = Validator::make($request->all(), [
        'name' => 'required',
        'point' => 'required',
    ]);

        if($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();

            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }

        $object =  LeadQualities::find($id);
        $object->name = $request->input("name");
        $object->point = $request->input("point");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('lead-qualities');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        LeadQualities::where("id",$id)->delete();
        return redirect()->back();
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = LeadQualities::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.lead-qualities.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
