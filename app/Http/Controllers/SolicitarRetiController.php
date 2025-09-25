<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Retiradas;
use App\Models\Itens_retirados;
use App\Models\Postos_saude;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SolicitarRetiController extends Controller
{

  //              FLUXO 
  // Adicina os id do front em um array []
  // Verifica se os id dos medicamentos existem em estoque
  // Verifica se os id dos postos são iguais 
  public function buscaDisponibilidade(Request $request)
  {

    $errorM = "Nenhum posto Com disponibilidade";

    // Lista dos medicamentos vindo do front
    $listaMediFront = $request->input('medicamentos');

    // Array com ids dos medicamentos solicitados
    $medIdsSolicitados = collect($listaMediFront)->pluck('id')->toArray();

    $countMedicamentos = count($medIdsSolicitados);

    $pComTodosMedicamentos = Estoque::select('id_postoFK')
      // Filtramos apenas as entradas que correspondem aos medicamentos solicitados.
      ->whereIn('id_medicamentoFK', $medIdsSolicitados)
      // Agrupamos o resultado por Posto.
      // Isso cria um grupo para cada posto que tem pelo menos um dos medicamentos.
      ->groupBy('id_postoFK')

      // O HAVING é a condição final. Contamos quantos medicamentos distintos
      // foram encontrados no grupo. Se for igual ao total de solicitados, o Posto é elegível.
      ->havingRaw('COUNT(DISTINCT id_medicamentoFK) = ?', [$countMedicamentos])

      // Pegamos apenas os IDs dos postos elegíveis
      ->pluck('id_postoFK')
      ->toArray();

    // Verifica se algum posto é elegível
    if (empty($pComTodosMedicamentos)) {
      // Retorna para a view anterior (ou uma view de erro) com uma mensagem
      return back()->with('error', $errorM);
    }

    // var_dump($pComTodosMedicamentos);
    $entradasQtt = $this->total_entrada($medIdsSolicitados, $pComTodosMedicamentos);
    $saidasQtt = $this->total_saida($medIdsSolicitados, $pComTodosMedicamentos);


    $disponibilidade = $this->calculoDisponibilidade($entradasQtt, $saidasQtt);

    // --- NOVA LÓGICA DE FILTRAGEM DE QUANTIDADE SOLICITADA ---

    // Criar um mapa das quantidades solicitadas (ID_Medicamento => Quantidade)
    $mapaQuantidadesSolicitadas = collect($listaMediFront)->pluck('quantidade', 'id');


    // 1. Agrupar os resultados de disponibilidade pelo ID do Posto
    $postosFiltrados = $disponibilidade->groupBy('id_postoFK');

    // 2. Filtragem final: O Posto é apto se CADA MEDICAMENTO atender à quantidade solicitada
    $idsPostosAptos = $postosFiltrados->filter(function ($itensDisponiveisPorPosto) use ($countMedicamentos, $mapaQuantidadesSolicitadas) {

      // Checagem 'AND' (garante que todos os medicamentos solicitados estão no array)
      if ($itensDisponiveisPorPosto->count() !== $countMedicamentos) {
        return false;
      }

      // b) Checagem de Quantidade (garante que a disponibilidade é maior ou igual à solicitada)
      foreach ($itensDisponiveisPorPosto as $item) {
        $idMedicamento = $item['id_medicamentoFK'];
        $quantidadeSolicitada = $mapaQuantidadesSolicitadas[$idMedicamento] ?? 0;

        // Se a disponibilidade de qualquer item for menor que a quantidade pedida, o Posto falha.
        if ($item['disponibilidade'] < $quantidadeSolicitada) {
          return false;
        }
      }

      // Se passou pela checagem 'AND' e pela checagem de Quantidade, o Posto é APTO.
      return true;
    })->keys()->toArray(); // Pega apenas os IDs dos Postos elegíveis

    // 3. Verifica se, após a filtragem final, ainda há postos
    if (empty($idsPostosAptos)) {
      return back()->with('error', $errorM);
    }

    // 4. Busca os dados COMPLETOs dos Postos aptos
    $postosDisponiveisData = Postos_saude::whereIn('id_posto', $idsPostosAptos)->get();

    // 5. Retorna a view
    return view('ProcurarUbs', [
      'solicitacao_retirada' => $listaMediFront,
      'postos_disponiveis' => $postosDisponiveisData,
      'detalhes_disponibilidade' => $disponibilidade
    ]);
  }




  public function calculoDisponibilidade($totalEntrada, $totalSaida)
  {
    // Cria uma chave única: "id_posto_id_medicamento"
    $entradasIndexadas = $totalEntrada->keyBy(function ($item) {
      return $item->id_postoFK . '_' . $item->id_medicamentoFK;
    });

    $saidasIndexadas = $totalSaida->keyBy(function ($item) {
      return $item->id_postoFK . '_' . $item->id_medicamentoFK;
    });

    // Calcular a Disponibilidade
      $disponibilidade = $entradasIndexadas->map(function ($entradaItem, $key) use ($saidasIndexadas) {
      $saidaItem = $saidasIndexadas->get($key);

      $totalSaida = $saidaItem ? (int) $saidaItem->total_saidas : 0;
      $totalEntrada = (int) $entradaItem->total_entrada;

      $disponibilidade = $totalEntrada - $totalSaida;

      if ($disponibilidade > 0) {
            // Se houver disponibilidade, busque os lotes
            $idPosto = $entradaItem->id_postoFK;
            $idMedicamento = $entradaItem->id_medicamentoFK;
            
            // CHAMA A NOVA FUNÇÃO: Busca todos os lotes para este Posto e Medicamento
            $lotes = $this->getLotesDisponiveis($idPosto, $idMedicamento);
        }

     return [
            'id_postoFK' => $idPosto,
            'id_medicamentoFK' => $idMedicamento,
            'estoque_total' => $totalEntrada,
            'saida_pendente' => $totalSaida,
            'disponibilidade' => $disponibilidade,
            // NOVO: Detalhes dos lotes disponíveis (será um array/Collection)
            'lotes_disponiveis' => $lotes ?? collect([]),
        ];
    })
    ->filter(function ($item) {
        return $item['disponibilidade'] > 0;
    })
    ->values();

    return $disponibilidade;
  }


  // Retorna um Enloquent class com as saidas baseadas no posto com estoque e medicamento 
  public function total_saida($mediSolicitados, $pComTodosMedicamentos)
  {

    $sts = "Pendente";

    return $totalSaidas = Itens_retirados::select(
      'retiradas.id_postoFK',
      'itens_retirados.id_medicamentoFK',
      DB::raw('SUM(qtt_saida) as total_saidas')
    )
      ->join('retiradas', 'itens_retirados.id_retiradaFK', '=', 'retiradas.id_retirada')
      ->whereIn('retiradas.id_postoFK', $pComTodosMedicamentos)
      ->where('retiradas.status', $sts)
      ->whereIn('itens_retirados.id_medicamentoFK', $mediSolicitados)
      ->groupBy('retiradas.id_postoFK', 'itens_retirados.id_medicamentoFK')
      ->get();

    // dd($totalSaidas);
  }


  // Verifica a quantidade de todos estoque do medicamento e qtt de todos os itens associados a retirada
  // *** $idEstoqueD -- id de todos os registros de estoque com medicamento solicitado pelo ususario 
  // *** $idMedi -- Medicamentos para agrupar as saidas
  // *** $idItemRetirada -- id de todos os itens retirados vindo do método buscaSaidas() 
  public function total_entrada($idmedicamentos, $pComTodosMedicamentos)
  {

    // Total daqueles medicamentos no estoque
    return $sumarioEstoque = Estoque::select(
      'id_medicamentoFK',
      'id_postoFK',
      DB::raw('SUM(qtt_entrada) as total_entrada')
    )
      ->whereIn('id_postoFK', $pComTodosMedicamentos)
      ->whereIn('id_medicamentoFK', $idmedicamentos)
      ->groupBy('id_postoFK', 'id_medicamentoFK')
      ->get();

    // dd($sumarioEstoque);
  }

  public function getLotesDisponiveis($idPosto, $idMedicamento)
{
    // A consulta deve considerar o estoque atual. Aqui simplificamos.
    // Lotes com qtt_entrada maior que zero E ordenados pelo mais antigo
    return Estoque::select('lote', DB::raw('SUM(qtt_entrada) as estoque_lote'))
        ->where('id_postoFK', $idPosto)
        ->where('id_medicamentoFK', $idMedicamento)
        
        // Se a qtt_entrada é a única coluna com valor positivo que representa o estoque:
        ->groupBy('lote')
        ->havingRaw('SUM(qtt_entrada) > 0') 
        
        // --- AQUI ESTÁ A CHAVE: Ordenar pela data de entrada mais antiga ---
        ->orderBy('data_entrada', 'asc') // FIFO: O registro com a data mais antiga vem primeiro
        
        ->get();
}
}
