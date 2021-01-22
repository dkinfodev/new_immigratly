<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class AssignLeads extends Model
{
    use HasFactory;
    protected $table = "assign_leads";



    static function deleteRecord($id){
        AssignLeads::where("id",$id)->delete();
    }
}
