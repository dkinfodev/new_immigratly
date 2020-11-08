<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request){
       	$viewData['pageTitle'] = "Services";
        $service_ids = ProfessionalServices::pluck("service_id");
        if(!empty($service_ids) > 0){
            $service_ids = $service_ids->toArray();
        }
        $main_services = DB::table(MAIN_DATABASE.".visa_services")
                                        ->where('parent_id',0)
                                        ->where(function($query) use($service_ids){
                                            if(count($service_ids) > 0){
                                                $query->whereNotIn("id",$service_ids);
                                            }
                                        })
                                        ->get();
        $all_services = array();
        foreach($main_services as $service){
            $temp = array();
            $temp = $service;
            $sub_services = DB::table(MAIN_DATABASE.".visa_services")
                                        ->where('parent_id',$service->id)
                                        ->where(function($query) use($service_ids){
                                            if(count($service_ids) > 0){
                                                $query->whereNotIn("id",$service_ids);
                                            }
                                        })
                                        ->get();
            if(!empty($sub_services)){
                $temp->sub_services = $sub_services;
            }else{
                $temp->sub_services = array();
            }
            $all_services[] = $service;
        }
        $viewData['all_services'] = $all_services;
        $my_services = ProfessionalServices::orderBy('id',"desc")->get();

        $viewData['my_services'] = $my_services;

        return view(roleFolder().'.services.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $records = ProfessionalServices::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.services.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit Service";
        $record = ProfessionalServices::where("id",$id)->first();
        $viewData['record'] = $record;
        return view(roleFolder().'.services.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'description' => 'required',
        ]);
        $id = base64_decode($id);
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
        $object =  ProfessionalServices::find($id);
        $object->price = $request->input("price");
        $object->description = $request->input("description");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('services');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function selectServices(Request $request){
        $validator = Validator::make($request->all(), [
            'services' => 'required',
        ]);
        
        if ($validator->fails()) {   
            return redirect()->back()->withErrors($validator->errors());
        }

        $services = $request->input('services');
        for($i=0;$i < count($services);$i++){
            $check_if_exists = ProfessionalServices::where("service_id",$services[$i])->count();
            if($check_if_exists <= 0){
                $object = new ProfessionalServices();
                $object->service_id = $services[$i];
                $object->save();
            }
        }
        return redirect()->back()->with("success","Services selected successfully");
    }
}
