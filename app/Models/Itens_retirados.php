<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itens_retirados extends Model
{
    use HasFactory;
    
    protected $table = 'itens_retirados';

    public $timestamps = false;


     protected $fillable = [
    'id_retiradaFK',
    'id_medicamentoFK',
    'qtt_saida',
    'lote',
];
}
