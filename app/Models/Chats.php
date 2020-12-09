<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
use App\Models\User;

class Chats extends Model
{
    use HasFactory;

    protected $table = "chats";

    static function deleteRecord($id){
        Chats::where("id",$id)->delete();
    }

    public function FileDetail()
    {
        return $this->belongsTo('App\Models\Documents','file_id','unique_id');
    }
}
