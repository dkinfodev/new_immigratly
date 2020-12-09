<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegesActions extends Model
{
    use HasFactory;
    protected $table = "privileges_actions";

    static function deleteRecord($id){
        Languages::where("id",$id)->delete();
    }
}
