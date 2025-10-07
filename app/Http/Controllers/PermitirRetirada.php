<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retiradas;
use App\Models\Itens_retirados;
use Illuminate\Support\Facades\DB;


class PermitirRetirada extends Controller
{
    public function dataRetirada(Request $request)
    {
        $idRetirada = $request->input('retirada');

        $dataItensRetirada = DB::table('itens_retirados')
        ->join('medicamentos', 'itens_retirados.id_medicamentoFK', '=', 'medicamentos.id_medicamento')

        ->select(
            'medicamentos.nome',
             'itens_retirados.qtt_saida',
        )
        ->where('itens_retirados.id_retiradaFK', $idRetirada)
        ->get();

        $dataRetirada = Retiradas::where('id_retirada',$idRetirada)->first();

        // dd($dataRetirada);

        return view('/permitirRetirada', [
            'dataItensRetirada' => $dataItensRetirada,
            'dataRetirada' => $dataRetirada
        ]);
    }
    public function alterarStatus(Request $request)
    {
        $idRetirada = $request->input('retirada');

    }
}
