<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postos_saude extends Model
{
     protected $primaryKey = 'id_posto';
     use HasFactory;
    
    protected $table = 'postos_saude';

}
