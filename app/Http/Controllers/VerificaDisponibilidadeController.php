<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Models\Estoque;
use App\Models\Retiradas;
use App\Models\Itens_retirados;
use App\Models\Postos_saude;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VerificaDisponibilidadeController extends Controller
{
    private $errorM = "Nenhum posto Com disponibilidade";

    public function solicitacaoIndisponivel()
    {
        return ['indisponivel' => $this->errorM];
    }

    // ... (dentro da classe VerificaDisponibilidadeController)

    public function calcularDisponibilidadePorLote(Collection $ocorrenciasOrdenadas, array $listaMediFront): Collection
    {
        // Cria um mapa para buscar rapidamente a quantidade solicitada pelo ID do medicamento
        // dd($listaMediFront);    
        $mapaQuantidadesSolicitadas = collect($listaMediFront)->pluck('quantidade', 'id');
        $disponibilidadeFinal = collect(); // Coleção de retorno dos postos aptos

        // Itera sobre os Postos
        foreach ($ocorrenciasOrdenadas as $postoDetalhe) {
            $idPosto = $postoDetalhe['id_postoFK'];
            $medicamentosAptos = collect();
            $postoApto = true; // Assume que o posto é apto até que um item falhe

            // Itera sobre cada Medicamento no Posto
            foreach ($postoDetalhe['medicamentosConstam'] as $idMedicamento => $lotesBrutos) {

                $quantidadeSolicitada = $mapaQuantidadesSolicitadas[$idMedicamento] ?? 0;

                // CHAMA O SQL OTIMIZADO (Faz a busca, subtração de saídas pendentes, e ordena FIFO)
                // A coleção $lotesFIFO contém APENAS lotes com saldo > 0
                $lotesFIFO = $this->getLotesDisponiveisReal($idPosto, $idMedicamento);

                // 1. Verifica se, após o desconto das saídas pendentes, o estoque para este item zerou
                if ($lotesFIFO->isEmpty()) {
                    $postoApto = false;
                    break; // Sai do loop de medicamentos e desqualifica o Posto
                }

                // 2. Calcula a disponibilidade TOTAL deste medicamento (soma do saldo real de todos os lotes)
                $disponibilidadeTotalItem = $lotesFIFO->sum('estoque_disponivel');

                // 3. FILTRO FINAL DE QUANTIDADE (Passos 4 e 5 do fluxograma)
                if ($disponibilidadeTotalItem < $quantidadeSolicitada) {
                    $postoApto = false;
                    break; // Posto reprovado. Sai do loop de medicamentos.
                }

                // Posto é apto, formata os dados para o front-end
                $lotesComEstoqueReal = $lotesFIFO->map(function ($lote) {
                    return [
                        'lote' => $lote->lote,
                        'estoque_disponivel' => (int) $lote->estoque_disponivel,
                        'data_entrada' => $lote->data_entrada,
                    ];
                });

                $medicamentosAptos->push([
                    'id_medicamentoFK' => $idMedicamento,
                    'disponibilidade_total' => $disponibilidadeTotalItem,
                    // ESTA LISTA JÁ ESTÁ EM ORDEM FIFO E COM SALDO REAL
                    'lotes_disponiveis' => $lotesComEstoqueReal->toArray(),
                ]);
            }

            // Adiciona o Posto apenas se ele atendeu à QTD de TODOS os medicamentos
            if ($postoApto) {
                $disponibilidadeFinal->push([
                    'id_postoFK' => $idPosto,
                    'detalhes_medicamentos' => $medicamentosAptos->toArray(),
                ]);
            }
        }

        // Garante o retorno de uma coleção (resolve o TypeError anterior)
        return $disponibilidadeFinal;
    }

    public function processarConsumoLotes(Collection $detalhesDisponibilidade, array $listaMediFront): Collection
    {
        $mapaQuantidadesSolicitadas = collect($listaMediFront)->pluck('quantidade', 'id');
        $postosLotesDisponiveis = collect();

        // Itera sobre os postos que passaram no filtro de quantidade TOTAL
        foreach ($detalhesDisponibilidade as $postoDetalhe) {

            $idPosto = $postoDetalhe['id_postoFK'];
            $lotesParaRetirada = collect();
            $postoAptoConsumo = true;

            // Busca os detalhes completos do Posto de Saúde para o modelo de saída
            $postoSaude = Postos_saude::find($idPosto);

            if (!$postoSaude) {
                // Caso não encontre o modelo, pula para o próximo posto
                continue;
            }

            // Itera sobre cada Medicamento do Posto
            foreach ($postoDetalhe['detalhes_medicamentos'] as $medicamentoDetalhe) {
                // dd($medicamentoDetalhe['lotes_disponiveis']);
                $idMedicamento = $medicamentoDetalhe['id_medicamentoFK'];
                $quantidadeSolicitadaOriginal = $mapaQuantidadesSolicitadas[$idMedicamento] ?? 0;
                $qtdRestante = $quantidadeSolicitadaOriginal; // A quantidade que ainda precisa ser coberta


                // Itera sobre os lotes FIFO (já ordenados e com saldo real)
                foreach ($medicamentoDetalhe['lotes_disponiveis'] as $lote) {

                    $saldoLote = $lote['estoque_disponivel'];

                    if ($qtdRestante <= 0) {
                        break; // Se já atendeu, para de olhar os lotes
                    }

                    if ($saldoLote >= $qtdRestante) {
                        // 1. O lote é suficiente para cobrir o restante

                        // Registra o Lote para a retirada, usando APENAS a quantidade restante necessária
                        $lotesParaRetirada->push([
                            'idMedicamento' => $idMedicamento,
                            'lote' => $lote['lote'],
                            // Registra o valor exato a ser consumido neste lote
                            'saldoUsadoParaRetirada' => $qtdRestante,
                            'data_entrada' => $lote['data_entrada'],

                        ]);
                        $qtdRestante = 0; // Pedido totalmente atendido
                        break; // Sai do loop de lotes

                    } else {
                        // 2. O lote é INSUFICIENTE. Deve ser consumido integralmente (Quebra de Lote)

                        // Registra o Lote, usando todo o seu saldo disponível
                        $lotesParaRetirada->push([
                            'idMedicamento' => $idMedicamento,
                            'lote' => $lote['lote'],
                            // Registra o valor total do lote, pois ele será zerado
                            'saldoUsadoParaRetirada' => $saldoLote,
                            'data_entrada' => $lote['data_entrada'],

                        ]);

                        // Subtrai o saldo do lote do restante a ser retirado
                        $qtdRestante -= $saldoLote;
                        // Continua para o próximo lote
                    }
                } // Fim do loop de lotes

                // 3. Checagem de Desqualificação Final (Segurança)
                // Se $qtdRestante > 0, significa que a soma total dos lotes falhou.
                if ($qtdRestante > 0) {
                    $postoAptoConsumo = false;
                    break; // Posto desqualificado, sai do loop de medicamentos
                }

            } // Fim do loop de medicamentos

            // 4. Adiciona o Posto ao resultado final, formatado no seu modelo
            if ($postoAptoConsumo) {
                $postosLotesDisponiveis->push([
                    'idPostoFK' => $idPosto,
                    'nome' => $postoSaude->nome,
                    'endereco' => $postoSaude->endereco,
                    'telefone' => $postoSaude->telefone,
                    // Note que 'loteRetirada' agora contém UM OU MAIS lotes
                    'loteRetirada' => $lotesParaRetirada->toArray(),
                ]);
            }
        }

        return $postosLotesDisponiveis;
    }

    //verificar na tabela estoque as ocorrências dos postos com todos os medicamentos solicitados 
    public function getOcorrenciaEstque(array $medIdsSolicitados)
    {
        $countMedicamentos = count($medIdsSolicitados);

        // 1. Encontra os IDs dos postos que possuem TODOS os medicamentos (Filtro inicial)
        $pComTodosMedicamentos = Estoque::select('id_postoFK')
            ->whereIn('id_medicamentoFK', $medIdsSolicitados)
            ->groupBy('id_postoFK')
            // Condição HAVING: Posto é elegível se tiver registros para TODOS os medicamentos
            ->havingRaw('COUNT(DISTINCT id_medicamentoFK) = ?', [$countMedicamentos])
            ->pluck('id_postoFK')
            ->toArray();
        if (empty($pComTodosMedicamentos)) {
            return $this->solicitacaoIndisponivel();
        } else {

            // 2. Busca os registros de ESTOQUE brutos para os postos e medicamentos aptos
            $estoquesAptos = Estoque::select(
                'id_postoFK',
                'id_medicamentoFK',
                'qtt_entrada',
                'lote',
                'data_entrada'
            )
                ->whereIn('id_postoFK', $pComTodosMedicamentos)
                ->whereIn('id_medicamentoFK', $medIdsSolicitados)
                ->get();


            // 3. Estrutura a coleção para o formato desejado (agrupado por Posto)
            $estoqueAgrupado = $estoquesAptos->groupBy('id_postoFK')->map(function ($itensPorPosto, $idPosto) {

                // Agrupa os itens por id_medicamentoFK dentro do posto
                $detalhesPorMedicamento = $itensPorPosto->groupBy('id_medicamentoFK')->map(function ($lotesPorMedicamento, $idMedicamento) {

                    // Mapeia para uma coleção simples dos lotes (como no seu exemplo)
                    return $lotesPorMedicamento->map(function ($lote) {
                        return [
                            'idMedicamento' => $lote->id_medicamentoFK, // Usando 'id' como chave para o medicamento
                            'qtt_entrada' => $lote->qtt_entrada,
                            'lote' => $lote->lote,
                            'data_entrada' => $lote->data_entrada,
                        ];
                    })->values()->toArray(); // Retorna um array simples de lotes para o medicamento
                });

                return [
                    'id_postoFK' => $idPosto,
                    'medicamentosConstam' => $detalhesPorMedicamento->toArray()
                ];
            })->values(); // Converte o mapa de volta para uma coleção sequencial

            // dd($estoqueAgrupado);
            return $estoqueAgrupado;

        }

    }

    /**
     * Itera sobre a coleção de ocorrências com estoque e ordena os lotes
     * de cada medicamento dentro de cada posto pela data de entrada (FIFO).
     *
     * @param Collection $ocorrenciasBrutas Coleção retornada de getOcorrenciaEstque.
     * @return Collection Coleção com a mesma estrutura, mas lotes ordenados.
     */
    public function ordenarLotesPorFIFO(Collection $ocorrenciasBrutas): Collection
    {
        // iterar sobre cada Posto na coleção
        return $ocorrenciasBrutas->map(function ($postoDetalhe) {

            $medicamentosConstam = collect($postoDetalhe['medicamentosConstam'])->map(function ($lotesDoMedicamento) {

                // Transforma o array de lotes em uma Coleção do Laravel para usar o sortBy
                $lotesCollection = collect($lotesDoMedicamento);

                // Aplica a ordenação: do mais antigo (ASC) ao mais recente pela 'data_entrada'
                $lotesOrdenados = $lotesCollection->sortBy('data_entrada')->values()->toArray();

                return $lotesOrdenados;
            });

            // Retorna o objeto do posto com os medicamentosConstam atualizados e ordenados
            $postoDetalhe['medicamentosConstam'] = $medicamentosConstam->toArray();
            return $postoDetalhe;
        });
    }

    /**
     * Método Otimizado (SQL): Faz a busca, soma, e subtração das saídas PENDENTES por lote (FIFO).
     * (Cobre as caixas 1, 2 e 3 do seu fluxograma de uma só vez).
     */
    private function getLotesDisponiveisReal($idPosto, $idMedicamento)
    {
        // 1. Subconsulta para somar as saídas PENDENTES
        $saidasPorLote = DB::table('itens_retirados')
            ->join('retiradas', 'itens_retirados.id_retiradaFK', '=', 'retiradas.id_retirada')
            ->select('itens_retirados.lote', DB::raw('SUM(itens_retirados.qtt_saida) as total_saidas_pendentes'))
            ->where('retiradas.id_postoFK', $idPosto)
            ->where('itens_retirados.id_medicamentoFK', $idMedicamento)
            // CORREÇÃO DE SINTAXE: Onde 'Pendente' é uma string, use aspas.
            ->where('retiradas.status', 'Pendente')
            ->groupBy('itens_retirados.lote');

        // 2. Consulta Principal: Subtração e Checagem (> 0)
        return Estoque::select(
            'estoque.lote',
            'estoque.data_entrada',
            // CORREÇÃO DO ERRO 1055: Envolvemos a expressão de saldo com SUM() ou MAX()
            // para satisfazer o strict mode, pois a agregação lógica já ocorreu.
            DB::raw('SUM(estoque.qtt_entrada) - IFNULL(MAX(saidas.total_saidas_pendentes), 0) as estoque_disponivel')
        )
            ->leftJoinSub($saidasPorLote, 'saidas', function ($join) {
                $join->on('estoque.lote', '=', 'saidas.lote');
            })
            ->where('estoque.id_postoFK', $idPosto)
            ->where('estoque.id_medicamentoFK', $idMedicamento)
            ->groupBy('estoque.lote', 'estoque.data_entrada')
            ->having('estoque_disponivel', '>', 0)
            ->orderBy('estoque.data_entrada', 'asc')
            ->get();
    }


}
