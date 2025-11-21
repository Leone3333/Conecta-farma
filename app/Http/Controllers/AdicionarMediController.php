<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;


class AdicionarMediController extends Controller
{
    public function add(Request $request)
    {
        if (!session()->has('login')) {
            // SE NÃO EXISTIR, REDIRECIONA PARA O LOGIN.
            // O método ->with('erro', ...) anexa uma mensagem de erro temporária na sessão.
            return redirect('/login')
                ->with('erroLogin', 'Você precisa estar logado para realizar esta operação.');
        } else {

            $idPosto = session('login')->id_postoFK;
            // dump($request->all());
            // dd($request->input('id_medicamento_selecionado'));

            if ($idPosto)
                $novaEntrada = Estoque::create([
                    'id_postoFK' => $idPosto,
                    'id_medicamentoFK' => $request->input('id_medicamento_selecionado'),
                    'qtt_entrada' => $request->input('quantidade'),
                    'lote' => $request->input('lote'),
                    'data_entrada' => now()->addYears()->format('Y-m-d H:i'),
                ]);

            return redirect()->route('retiradas.index')->with('sucesso', 'Entrada de medicamento registrada com sucesso!');
        }
    }
}
