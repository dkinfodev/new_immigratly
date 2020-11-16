<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaServices extends Model
{
    use HasFactory;
    protected $table = "visa_services";

    public function SubServices()
    {
        return $this->hasMany('App\Models\VisaServices','parent_id');
    }

    static function deleteRecord($id){
        VisaServices::where("id",$id)->delete();
        VisaServices::where("parent_id",$id)->delete();
    }
}
