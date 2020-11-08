<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\ProgramTypes;

class ProgramTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = ProgramTypes::count();
        $viewData['pageTitle'] = "Program Types";
        return view(roleFolder().'.program-types.list',$viewData);
    } 

    public function getList(Request $request)
    {
        $records = ProgramTypes::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.program-types.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Program Types";
        return view(roleFolder().'.program-types.add',$viewData);
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
        
        $object =  new ProgramTypes;
        $object->name = $request->input("name");
        $object->point = $request->input("point");
        $object->save();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('program-types');
        $response['message'] = "Record added successfully";
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = ProgramTypes::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Program types";
        return view(roleFolder().'.program-types.edit',$viewData);
    }

    public function update($id,Request $request){
         $id = base64_decode($id);
        $object =  ProgramTypes::find($id);
     $validator = Validator::make($request->all(), [
        'name' => 'required',
        'point' => 'required',
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
        $object->point = $request->input("point");        
        $object->save();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('program-types');
        $response['message'] = "Record updated successfully";
        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        ProgramTypes::where("id",$id)->delete();
        return redirect()->back();
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = ProgramTypes::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.program-types.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
