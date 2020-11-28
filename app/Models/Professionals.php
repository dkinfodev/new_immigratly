<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
<<<<<<< HEAD
use App\Models\Languages;
use App\Models\LicenceBodies;
=======
>>>>>>> c3ff535466933d15f0cdf7c8492fbfbd4b9c7224

class Professionals extends Model
{
    protected $table = "professionals";

<<<<<<< HEAD
    
=======
>>>>>>> c3ff535466933d15f0cdf7c8492fbfbd4b9c7224
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
