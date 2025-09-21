<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    
    // Informe ao Eloquent que a tabela é 'estoque' (no singular)
    protected $table = 'estoque';
}
