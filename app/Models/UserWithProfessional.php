<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithProfessional extends Model
{
    use HasFactory;
    protected $table = 'user_with_professional';
}