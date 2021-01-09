<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $table = "articles";

    static function deleteRecord($id){
        CaseFolders::where("id",$id)->delete();
    }
}
