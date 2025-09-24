<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itens_retirados extends Model
{
    use HasFactory;
    
    protected $table = 'itens_retirados';

     protected $fillable = [
    'id_retiradasFK',
    'id_medicamentosFK',
    'qtt_saida',
    'lote',
];
}
