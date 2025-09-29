<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Retiradas;
use App\Models\Itens_retirados;
use App\Models\Postos_saude;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class SolicitarRetiradaController extends Controller
{

    public function __construct(VerificaDisponibilidadeController $disponibilidadeController)
    {
        $this->disponibilidadeController = $disponibilidadeController;
    }
    // Extrai front organiza os arrays para verificar disponibiliade e retorna as respostas para o front
    public function solicitar(Request $request)
    {
        try {

            // Lista dos medicamentos vindo do front
            $listaMediFront = $request->input('medicamentos');
            $medIdsSolicitados = collect($listaMediFront)->pluck('id')->toArray();

            // dd($listaMediFront);
        } catch (Exception $error) {
            \Log::error("Erro na busca de disponibilidade: " . $error->getMessage());
            return back()->with('error', "Falha no envio dos dados.");

        }

        // array
        $ocorreciasEstoque = $this->disponibilidadeController->getOcorrenciaEstque($medIdsSolicitados);

        $ocorreciasOrdenadas = $this->disponibilidadeController->ordenarLotesPorFIFO($ocorreciasEstoque);
        // dd($ocorreciasEstoque);

        $detalhesDisponibilidade = $this->disponibilidadeController->calcularDisponibilidadePorLote($ocorreciasOrdenadas, $listaMediFront);

        $this->errorBusca($detalhesDisponibilidade);

        // dd($detalhesDisponibilidade);

        // collection
        $postosLotesDisponiveis = $this->disponibilidadeController->processarConsumoLotes($detalhesDisponibilidade, $listaMediFront);

        $this->errorBusca($postosLotesDisponiveis);

        // dd($postosLotesDisponiveis);

        return view('ProcurarUbs', [
            'postosLotesDisponiveis' => $postosLotesDisponiveis,
            'solicitacao' => $listaMediFront
        ]);
    }

    // usar em collection
    private function errorBusca($consulta)
    {
        if ($consulta->isEmpty()) {
            return back()->with('error', "Nenhum posto tem ocorrências para todos os itens solicitados.");
        }
    }



}
