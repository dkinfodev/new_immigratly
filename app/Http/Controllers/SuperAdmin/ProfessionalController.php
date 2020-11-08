<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use DB;

use App\Models\User;
use App\Models\Professionals;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function activeProfessionals()
    {
        $viewData['total_users'] = Professionals::count();
        $viewData['active_users'] = Professionals::where('panel_status','1')->count();
        $viewData['inactive_users'] = Professionals::where('panel_status','0')->count();
       	$viewData['pageTitle'] = "Active Professionals";
        return view(roleFolder().'.professionals.active-lists',$viewData);
    }

    public function getActiveList(Request $request)
    {
        $records = Professionals::orderBy('id',"desc")->where('panel_status',1)->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.professionals.ajax-active',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function inactiveProfessionals()
    {
        $viewData['total_users'] = Professionals::count();
        $viewData['active_users'] = Professionals::where('panel_status','1')->count();
        $viewData['inactive_users'] = Professionals::where('panel_status','0')->count();
        $viewData['pageTitle'] = "Inactive Professionals";
        return view(roleFolder().'.professionals.inactive-lists',$viewData);
    }

    public function getPendingList(Request $request)
    {
        $records = Professionals::orderBy('id',"desc")->where('panel_status',0)->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.professionals.ajax-active',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function changeStatus($status,Request $request)
    {
        $id = $request->input("id");
        if($status == 'active'){
            $upData['panel_status'] = 1;
        }else{
            $upData['panel_status'] = 0;
        }
        Professionals::where("id",$id)->update($upData);
        
        $response['status'] = true;
        $response['message'] = "Professional status change to ".$status;
        return response()->json($response);
    }

    public function profileStatus($status,Request $request)
    {
        $id = $request->input("id");
        $db_prefix = db_prefix();
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;
        $database = $db_prefix.$subdomain;
        $professional_status = DB::table($database.".domain_details")->first();

        if($status == 'active'){
            $upData['profile_status'] = 2;
            $response['message'] = "Professional profile verified";
        }else{
            $upData['profile_status'] = 0;
            $response['message'] = "Professional profile unverified";
        }
        DB::table($database.".domain_details")->where('id',$professional_status->id)->update($upData);
        $response['status'] = true;
        
        return response()->json($response);
    }
}
