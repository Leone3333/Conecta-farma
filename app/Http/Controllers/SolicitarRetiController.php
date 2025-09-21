<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolicitarRetiController extends Controller
{
    public function buscaDisponibilidade(Request $request)
    {
        dd($request->all());
    }
}
