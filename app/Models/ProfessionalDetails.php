<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalDetails extends Model
{
    protected $table = "professional_details";

    public function User()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
