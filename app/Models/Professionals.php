<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Professionals extends Model
{
    protected $table = "professionals";

    public function PersonalDetail($subdomain)
    {
        $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".users")->where("role","admin")->first();
        return $data;
    }

    public function CompanyDetail($subdomain)
    {
        $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        return $data;
    }

    public function getLanguage($id){
        $object = Languages::where("id",$id)->first();
        return $object->name;
    }

    public function getLicenceBodies($id){
        $object = LicenceBodies::where("id",$id)->first();
        return $object->name;
    }

}
