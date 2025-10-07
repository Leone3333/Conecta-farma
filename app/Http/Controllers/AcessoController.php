<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Retiradas;
use App\Models\Postos_saude;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    // Função para logar no sistema
    public function login(Request $request)
    {   
        if (!session()->has('login')) {
            return redirect()->route('login');
        }

        if (!isset($request)) {
            return back()->with('erroLogin', 'Por favor digite valores validos');
        } else {

            
            $matricula = $request->input('matricula');
            $senha = $request->input('senha');

            $funcionario = Funcionario::where('matricula', $matricula)->first();

                // dump($funcionario->id_postoFK);
                if ($funcionario->senha == $senha) {
                    $idPosto = $funcionario->id_postoFK;
                    $retiradas = $this->retiradasAssociadas($idPosto);
                    
                    if ($retiradas->isEmpty()) {
                        return back()->with('0retirada', 'Sem retiradas no posto');
                    }
                    
                    $posto = Postos_saude::where('id_posto',$funcionario->id_postoFK)->first();
                    session()->put('login', $funcionario);
                    return view('codigoRetirada', ['retiradas' => $retiradas, 'posto' => $posto]);
                }
            return back()->with('erroLogin', 'Usuario não cadastrado tente novamente ou avise ao suporte tecnico');
        }
    }

    public function retiradasAssociadas($idPosto)
    {
        $retiradas = Retiradas::where('id_postoFK', $idPosto)
            ->where('status', 'Pendente')
            ->get();
        
        return $retiradas;
    }
}
