<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    // Função para logar no sistema
    public function login(Request $request)
    {
        if(!isset($request)){
            return back()->with('erroLogin', 'Por favor digite valores validos');
        }else{
            $matricula = $request->input('matricula');
            $senha = $request->input('senha');
            
            $funcionarios = Funcionario::all();
            
            foreach($funcionarios as $funcionario){
                // dump($funcionario->id_postoFK);
                if($funcionario->matricula == $matricula && $funcionario->senha == $senha){
                    session()->put('login', $funcionario);
                    return redirect()->route('codigos');
                }else{
                    return back()->with('erroLogin', 'Usuario não cadastrado tente novamente ou avise ao suporte tecnico');
                }
            }
        }


        
    }
}
