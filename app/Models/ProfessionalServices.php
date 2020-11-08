<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class ProfessionalServices extends Model
{
    use HasFactory;
    protected $table = "professional_services";

    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("id",$id)->first();
        return $service;
    }

    public function checkIfExists($service_id){
    	$is_exists = ProfessionalServices::where("service_id",$service_id)->count();
    	return $is_exists;
    }
}
