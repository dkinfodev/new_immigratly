<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTasks extends Model
{
    use HasFactory;
    protected $table = "case_tasks";

    static function deleteRecord($id){
        CaseTasks::where("id",$id)->delete();
    }
}
