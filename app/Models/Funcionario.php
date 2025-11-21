<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    // Define a chave primária customizada.
    protected $primaryKey = 'id_funcionario';
    // ----------------------------

    protected $table = 'funcionarios'; // Se sua tabela se chama 'funcionarios'

    public $timestamps = false;
}
