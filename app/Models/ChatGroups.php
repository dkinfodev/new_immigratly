<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroups extends Model
{
    use HasFactory;
    protected $table = "chat_groups";

    static function deleteRecord($id){
        ChatGroups::where("id",$id)->delete();
    }
}
