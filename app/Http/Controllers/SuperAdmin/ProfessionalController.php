<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use DB;

use App\Models\User;
use App\Models\Professionals;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;

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

    public function viewDetail($id){

        $id = base64_decode($id);

        $record = Professionals::where("id",$id)->first();
        $pd = $record->PersonalDetail($record->subdomain);
        $cd = $record->CompanyDetail($record->subdomain);
        $viewData['subdomain'] = $record->subdomain;

        $viewData['record'] = $record;
        $viewData['user'] = $pd;
        $viewData['company_details'] = $cd;
        $viewData['pageTitle'] = $pd->first_name;

        $language_id = $pd->languages_known;
        if($language_id != ''){
            $language_id = json_decode($language_id,true);
        }else{
            $language_id = array();    
        }

        $languages_known = array();
        foreach ($language_id as $key => $l) {
            $languages_known[] = $record->getLanguage($l);
        }

        $viewData['languages'] = implode(",",$languages_known);


        $license_id = $cd->license_body;
        if($license_id != ''){
            $license_id = json_decode($license_id,true);
        }else{
            $license_id = array();
        }

        $license_bodies = array();
        foreach ($license_id as $key => $l) {
            $license_bodies[] = $record->getLicenceBodies($l);
        }

        $viewData['licenceBodies'] = implode("<br>",$license_bodies);
        
        $countries = Countries::where('id',$pd->country_id)->first();

        $viewData['countries'] = $countries;

        $comp_countries = Countries::where('id',$cd->country_id)->first();
        $viewData['comp_countries'] = $comp_countries;

        $states = States::where('id',$pd->state_id)->first();
        $viewData['states'] = $states;

        $comp_states = States::where('id',$cd->state_id)->first();
        $viewData['comp_states'] = $comp_states;

        $cities = Cities::where('id',$pd->city_id)->first();
        $viewData['cities'] = $cities;

        $comp_cities = Cities::where('id',$cd->city_id)->first();
        $viewData['comp_cities'] = $comp_cities;

        $viewData['phonecode'] = $cities;

        return view(roleFolder().'.professionals.view-details',$viewData);
        
    }

    public function addNotes($id){
    
        $id = base64_decode($id);        
        $db_prefix = db_prefix();
        $record = Professionals::where("id",$id)->first();
        $subdomain = $record->subdomain;
        $database = $db_prefix.$subdomain;
        $notes = DB::table($database.".domain_details")->first();
        $viewData['notes'] = $notes->admin_notes;
        $viewData['notes_updated_on'] = $notes->notes_updated_on;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Add Notes";
        $view = View::make(roleFolder().'.professionals.modal.add-notes',$viewData);
        
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveNotes(Request $request){
        $id = $request->input("id");
        $db_prefix = db_prefix();
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;
        $database = $db_prefix.$subdomain;
        $professional_status = DB::table($database.".domain_details")->first();

        if(!empty($request->input('notes'))){
            $upData['admin_notes'] = $request->input('notes');
            $upData['notes_updated_on'] = date('d-m-Y H:m:s');
        }

        DB::table($database.".domain_details")->where('id',$professional_status->id)->update($upData);
        $response['status'] = true;
        
        return response()->json($response);
    }
}
