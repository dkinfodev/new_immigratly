<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\User;
use App\Models\LicenceBodies;
use App\Models\Countries;

class LicenceBodiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function licenceBodies()
    {
        $viewData['total_bodies'] = LicenceBodies::count();
        //$viewData['records'] = LicenceBodies::count();
        $viewData['pageTitle'] = "Licence Bodies";
        return view(roleFolder().'.licence-bodies.list',$viewData);
    } 

    public function getList(Request $request)
    {
        $records = LicenceBodies::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.licence-bodies.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $countries = Countries::get();
        $viewData['countries'] = $countries;

        $viewData['pageTitle'] = "Add Licence Bodies";
        return view(roleFolder().'.licence-bodies.add',$viewData);
    }


    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
        ]);
        
        session(['redirect_back' => $request->input('redirect_back')]);
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

        $object =  new LicenceBodies;
        $object->name = $request->input("name");
        $object->country_id = $request->input("country_id");
        $object->created_at = $now;
        $object->updated_at = null;
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('licence-bodies');
        
        $response['message'] = "Record added successfully";
        
        /*
        \Session::flash('success_message', 'Licence Body has been added successfully!'); */
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = LicenceBodies::where("id",$id)->first();
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        $viewData['pageTitle'] = "Edit Licence Body";
        return view(roleFolder().'.licence-bodies.edit',$viewData);
    }

    public function update(Request $request){
     $validator = Validator::make($request->all(), [
        'name' => 'required',
        'country_id' => 'required',
    ]);

     session(['redirect_back' => $request->input('redirect_back')]);
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
    $object =  LicenceBodies::find($id);
    $object->name = $request->input("name");
    $object->country_id = $request->input("country_id");
    $object->updated_at = $now;
    $object->save();

    $response['status'] = true;
    $response['redirect_back'] = baseUrl('/licence-bodies');

    $response['message'] = "Record updated successfully";

        /* \Session::flash('success_message', 'Licence Body has been added successfully!'); */
        
        return response()->json($response);
    }

    public function delete($id){
        $id = base64_decode($id);
        LicenceBodies::where("id",$id)->delete();
        return redirect()->back();
    }

    public function search($keyword){
        $keyword = $keyword;
        
        $records = LicenceBodies::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.licence-bodies.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
