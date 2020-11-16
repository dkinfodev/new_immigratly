<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cases extends Model
{
    use HasFactory;
    protected $table = "cases";
    
    public function VisaService()
    {
        return $this->belongsTo('App\Models\ProfessionalServices','visa_service_id');
    }
    public function AssingedMember()
    {
        return $this->hasMany('App\Models\CaseTeams','case_id')->with(['Member']);
    }
    public function Client($id)
    {
        $data = DB::table(MAIN_DATABASE.".users")->where("unique_id",$id)->first();
        return $data;
    }
    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("id",$id)->first();
        return $service;
    }

    static function deleteRecord($id){
        Cases::where("id",$id)->delete();
    }
}
