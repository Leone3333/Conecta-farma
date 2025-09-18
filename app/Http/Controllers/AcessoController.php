<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    // Função para logar no sistema
    public function login(Request $request)
    {
        dd(Funcionario::all());
        dd($request->all());
    }
}
