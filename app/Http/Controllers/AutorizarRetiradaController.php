<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retiradas;
use App\Models\Medicamento;
use App\Models\Postos_saude;


class AutorizarRetiradaController extends Controller
{

    public function __construct(AcessoController $acessoController)
    {
        $this->acessoController = $acessoController;

    }
    public function updateRetirada(Request $request)
    {

        $idRetirada = $request->input('retirada');
        $newStatus = $request->input('status');
        // dump($idRetirada);


        $retiradaUpdate = Retiradas::find($idRetirada);

        $retiradaUpdate->status = $newStatus;
        $retiradaUpdate->save();

        return redirect()->route('retiradas.index');
    }

    public function listaRetiradas()
    {
        if (!session()->has('login')) {
            return redirect()->route('login');
        } else {
            $idPosto = session('login')->id_postoFK;
            $posto = Postos_saude::where('id_posto', $idPosto )->first();
            $retiradas = Retiradas::pendentesPorPosto($idPosto );

            return view('codigoRetirada', ['retiradas' => $retiradas, 'posto' => $posto, 'medicamentos' => Medicamento::all()]);
           
        }
    }
}
