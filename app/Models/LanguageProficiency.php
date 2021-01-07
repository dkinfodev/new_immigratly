<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageProficiency extends Model
{
    use HasFactory;
    protected $table = "language_proficiency";

    static function deleteRecord($id){
        LanguageProficiency::where("id",$id)->delete();
    }
}
