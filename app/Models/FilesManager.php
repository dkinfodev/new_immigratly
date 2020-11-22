<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesManager extends Model
{
    use HasFactory;
    protected $table = "files_manager";

    static function deleteRecord($id){
        FilesManager::where("id",$id)->delete();
    }
}
