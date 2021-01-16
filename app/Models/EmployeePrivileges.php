<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePrivileges extends Model
{
    use HasFactory;
    protected $table = "employee_privileges";

    static function deleteRecord($id){
        EmployeePrivileges::where("id",$id)->delete();
<<<<<<< HEAD
        EmployeePrivilegesAction::where("module_id",$id)->delete();
=======
>>>>>>> e5fb5987d66674af94dc8171075020ea0d1da7aa
    }

    public function Actions()
    {
        return $this->hasMany('App\Models\EmployeePrivilegesActions','module_id');
    }
}
