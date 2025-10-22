<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PostosFactory;
use App\Models\Estoque;
use App\Models\Retiradas;

class Postos_saude extends Model
{
    protected $primaryKey = 'id_posto';
    use HasFactory;

    public $timestamps = false;

    protected $table = 'postos_saude';


    public function estoques()
    {
        // 'Estoque::class' é o Model filho
        // 'id_postosFK' é a chave estrangeira na tabela 'estoque'
        return $this->hasMany(Estoque::class, 'id_postosFK');
    }

    // Método que implementa o HasMany para a tabela 'retiradas'
    public function retiradas()
    {
        // 'Retiradas::class' é o Model filho
        // 'id_postosFK' é a chave estrangeira na tabela 'retiradas'
        return $this->hasMany(Retiradas::class, 'id_postosFK');
    }

    protected static function newFactory()
    {
        return PostosFactory::new();
    }
}
