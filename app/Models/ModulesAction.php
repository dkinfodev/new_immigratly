<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulesAction extends Model
{
    use HasFactory;
    protected $table = "professional_modules_action";

    static function deleteRecord($id){
        ModulesAction::where("id",$id)->delete();
    }
}
