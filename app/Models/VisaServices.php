<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\DocumentFolder;

class VisaServices extends Model
{
    use HasFactory;
    protected $table = "visa_services";

    public function SubServices()
    {
        return $this->hasMany('App\Models\VisaServices','parent_id');
    }

    public function Articles()
    {
        return $this->hasMany('App\Models\Articles','category_id');
    }

    public function Webinars()
    {
        return $this->hasMany('App\Models\Webinar','category_id');
    }

    public function DocumentFolders($id)
    {
        $visa_service = VisaServices::where("id",$id)->first();
        
        if($visa_service->document_folders != ''){
            $document_folder = explode(",",$visa_service->document_folders);
            
            $document_folders = DocumentFolder::whereIn("id",$document_folder)->get();    
        }else{
            $document_folders = array();
        }
        
        return $document_folders;
    }
    
    static function deleteRecord($id){
        VisaServices::where("id",$id)->delete();
        VisaServices::where("parent_id",$id)->delete();
    }
}
