<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Retiradas;
use App\Models\Postos_saude;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    // Função para logar no sistema
    public function login(Request $request)
    {

        // 1. Validação simples: Garante que os campos foram enviados
        if (!$request->filled(['matricula', 'senha'])) {
            return back()->with('erroLogin', 'Por favor, digite a matrícula e a senha.');
        }

        $matricula = $request->input('matricula');
        $senha = $request->input('senha');

        $funcionario = Funcionario::where('matricula', $matricula)->first();

        if (!$funcionario) {
            return back()->with('erroLogin', 'Usuario não cadastrado tente novamente ou avise ao suporte tecnico');
        }

        // dump($funcionario->id_postoFK);
        if ($funcionario->senha != $senha) {
            return back()->with('erroLogin', 'Senha incorreta tente novamente ou avise ao suporte tecnico');
        }

        // --- LOGIN BEM-SUCEDIDO ---
        $idPosto = $funcionario->id_postoFK;
        $retiradas = Retiradas::pendentesPorPosto($idPosto);

        if ($retiradas->isEmpty()) {
            return back()->with('0retirada', 'Sem retiradas no posto');
        }

        $posto = Postos_saude::where('id_posto', $funcionario->id_postoFK)->first();
        session()->put('login', $funcionario);

        return view('codigoRetirada', [
            'retiradas' => $retiradas,
            'posto' => $posto,
            'medicamentos' => Medicamento::all()
        ]);
    }
}
