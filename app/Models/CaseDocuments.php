<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDocuments extends Model
{
    use HasFactory;
    protected $table = "case_documents";

    public function Document($id)
    {
        $service = DB::table(MAIN_DATABASE.".document_folder")->where("id",$id)->first();
        return $service;
    }
}
