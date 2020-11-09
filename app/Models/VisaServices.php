<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaServices extends Model
{
    use HasFactory;
    protected $table = "visa_services";

    public function SubServices()
    {
        return $this->hasMany('App\Models\VisaServices','parent_id');
    }
}
