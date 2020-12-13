<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class Leads extends Model
{
    use HasFactory;
    protected $table = "leads";

    public function VisaService()
    {
        return $this->belongsTo('App\Models\ProfessionalServices','visa_service_id','unique_id');
    }

    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        return $service;
    }

    static function deleteRecord($id){
        Leads::where("id",$id)->delete();
    }
}
