<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
class DocumentChats extends Model
{
    use HasFactory;

    protected $table = "document_chats";

    static function deleteRecord($id){
        Documents::DocumentChats("id",$id)->delete();
    }
}
