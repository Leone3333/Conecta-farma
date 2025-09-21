<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SolicitarRetiController extends Controller
{

    //              FLUXO 
    // Adicina os id do front em um array []
    // Verifica se os id dos medicamentos existem em estoque
    // Verifica se os id dos postos são iguais 
    public function buscaDisponibilidade(Request $request)
    {
        $errorM = "Nenhum posto Com disponibilidade";
        $listaMediFront = $request->input('medicamentos');
        $medIdsSolicitados = collect($listaMediFront)->pluck('id')->toArray();
        
        // Busca todos os medicamentos da lista que existem no estoque
        $mediExiste = Estoque::whereIn('id_medicamentoFK', $medIdsSolicitados)->get();

        // Agrupa os medicamentos encontrados
        $mPorPosto = $mediExiste->groupBy('id_postoFK');

         // Array para armazenar os IDs dos postos que atendem à requisição completa
        $idPostoCestoque = [];

      foreach($mPorPosto as $postoId => $medicamentosDoPosto){
        
        // ids do medicamentos encontrados no posto 
        $idsMposto = $medicamentosDoPosto->pluck('id_medicamentoFK')->toArray();

        // Compara se o conjunto de IDs encontrados é igual ao conjunto de IDs solicitados
        // array_intersect() retorna os elementos que estão em ambos os arrays
        if(count(array_intersect($medIdsSolicitados, $idsMposto)) === count($medIdsSolicitados)){
            // Posto com estoque
            $idPostoCestoque[] = $postoId; 
          }else{
            echo($errorM);
          }
        }
        // dd($idPostoCestoque);



    }
}
