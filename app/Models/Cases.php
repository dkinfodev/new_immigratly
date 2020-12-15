<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\CaseDocuments;
use App\Models\ServiceDocuments;
class Cases extends Model
{
    use HasFactory;
    protected $table = "cases";
    
    public function VisaService()
    {
        return $this->belongsTo('App\Models\ProfessionalServices','visa_service_id','unique_id');
    }
    public function AssingedMember()
    {
        return $this->hasMany('App\Models\CaseTeams','case_id','unique_id')->with(['Member']);
    }
    public function Client($id)
    {
        $data = DB::table(MAIN_DATABASE.".users as us")
                ->leftJoin(MAIN_DATABASE.".user_details as ud","ud.user_id","=","us.unique_id")
                ->leftJoin(MAIN_DATABASE.".countries as ct","ct.id","=","ud.country_id")
                ->leftJoin(MAIN_DATABASE.".states as st","st.id","=","ud.state_id")
                ->leftJoin(MAIN_DATABASE.".cities as cty","cty.id","=","ud.city_id")
                ->where("unique_id",$id)
                ->select("us.*","ud.gender","ud.country_id","ud.state_id","ud.city_id","ud.address","ud.zip_code","ud.languages_known","ud.date_of_birth","ct.name as country_name","st.name as state_name","cty.name as city_name")
                ->first();
        return $data;
    }
    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        return $service;
    }

    static function caseDocuments($case_id,$folder_id,$return='record'){
        $documents = CaseDocuments::with('FileDetail')->where("case_id",$case_id)->where("folder_id",$folder_id)->get();
        if($return == 'count'){
            return count($documents);
        }
        return $documents;
    }

    static function documentInfo($folder_id,$type){
        $document = array();
        if($type == 'default'){
            $document = DB::table(MAIN_DATABASE.".documents_folder")->where("unique_id",$folder_id)->first();
        }
        if($type == 'other'){
            $document = ServiceDocuments::where("unique_id",$folder_id)->first();
        }
        return $document;
    }

    static function deleteRecord($id){
        Cases::where("id",$id)->delete();
    }

    public function Chats()
    {
        return $this->hasMany('App\Models\Chats','case_id')->where("chat_type","case_chat");
    }
}
