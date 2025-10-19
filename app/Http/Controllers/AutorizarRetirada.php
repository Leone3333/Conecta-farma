<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retiradas;


class AutorizarRetirada extends Controller
{
      public function updateRetirada(Request $request)
    {
        
        $idRetirada = $request->input('retirada');
        $newStatus = $request->input('status');
        // dump($idRetirada);
        

        $retiradaUpdate = Retiradas::find($idRetirada);
       
        $retiradaUpdate->status = $newStatus;
        $retiradaUpdate->save();

        return view('codigoRetirada');
    }
}
