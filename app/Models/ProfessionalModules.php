<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalModules extends Model
{
    use HasFactory;
    protected $table = "professional_modules";

    static function deleteRecord($id){
        Languages::where("id",$id)->delete();
    }
}
