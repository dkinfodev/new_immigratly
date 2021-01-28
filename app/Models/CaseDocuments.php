<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDocuments extends Model
{
    use HasFactory;
    protected $table = "case_documents";

    static function deleteRecord($id){
        CaseDocuments::where("id",$id)->delete();
    }
    
    public function Document($id)
    {
        $service = DB::table(MAIN_DATABASE.".document_folder")->where("id",$id)->first();
        return $service;
    }

    public function FileDetail()
    {
        return $this->belongsTo('App\Models\Documents','file_id','unique_id');
    }

    public function Chats()
    {
        return $this->hasMany('App\Models\DocumentChats','document_id','unique_id');
    }
    public function ChatUsers()
    {
        return $this->hasMany('App\Models\DocumentChats','document_id','unique_id')->groupBy("created_by");
    }
}
