<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\Languages;

class LanguagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function languages()
    {
        $viewData['total_bodies'] = Languages::count();
        $viewData['pageTitle'] = "Languages";
        return view(roleFolder().'.languages.list',$viewData);
    } 

    public function getList(Request $request)
    {
        $records = Languages::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.languages.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Language";
        return view(roleFolder().'.languages.add',$viewData);
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
        
        $now = \Carbon\Carbon::now();

        $object =  new Languages;
        $object->name = $request->input("name");
        $object->created_at = $now;
        $object->updated_at = null;
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('languages');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = Languages::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Language";
        return view(roleFolder().'.languages.edit',$viewData);
    }

    public function update(Request $request){
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

        $now = \Carbon\Carbon::now();

        $id = $request->input("rid");
        $id = base64_decode($id);
        $object =  Languages::find($id);
        $object->name = $request->input("name");
        $object->updated_at = $now;
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/languages');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        Languages::where("id",$id)->delete();
        return redirect()->back();
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = Languages::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.languages.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
