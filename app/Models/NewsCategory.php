<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = "news_category";

 	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        NewsCategory::where("id",$id)->delete();
        News::where("category_id",$id)->delete();
    }
}
