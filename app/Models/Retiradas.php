<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retiradas extends Model
{

    use HasFactory;
// Defina o nome da sua tabela
    protected $table = 'retiradas';

    // Defina o nome da sua chave primária
    protected $primaryKey = 'id_retirada';

    public $timestamps = false;
    
    protected $fillable = [
        // As colunas aqui devem ser os nomes EXATOS da sua tabela
        'id_funcionarioFK',
        'id_postoFK',
        'cod_saida',
        'status',
        'data_saida',
    ];

    // Retorna uma collection com todas as retiradas com status Pendente associada a 1 idPosto válido
       public static function pendentesPorPosto($idPosto)
    {
        $retiradas = Retiradas::where('id_postoFK', $idPosto)
            ->where('status', 'Pendente')
            ->get();
        
        return $retiradas;
    }
}
