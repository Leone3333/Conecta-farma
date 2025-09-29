<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Medicamento extends Model
{

    use HasFactory;
    // Defina o nome da sua tabela
    protected $table = 'medicamentos';

    // Defina o nome da sua chave primária
    protected $primaryKey = 'id_medicamento';

    public $timestamps = false;

}
