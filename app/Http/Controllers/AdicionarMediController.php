<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;


class AdicionarMediController extends Controller
{
    public function add(Request $request)
    {
        $idPosto = session('login')->id_postoFK;
        // dump($request->all());
        // dd($request->input('id_medicamento_selecionado'));

        $novaEntrada = Estoque::create([
            'id_postoFK' => $idPosto,
            'id_medicamentoFK' => $request->input('id_medicamento_selecionado'),
            'qtt_entrada' => $request->input('quantidade'),
            'lote' => $request->input('lote'),
            'data_entrada' => now()
        ]);

        return redirect()->route('retiradas.index');
    }
}
