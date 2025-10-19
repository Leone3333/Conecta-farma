<?php

namespace App\Http\Controllers;



use App\Models\Retiradas;
use App\Models\Itens_retirados;
use App\Models\Postos_saude;
use App\Models\Medicamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ConfirmarSoliController extends Controller
{
    //
    public function confirmar(Request $request)
    {
        $idRetiradaPosto = $request->input('idPosto');
        $codigoRetirada = $request->input('codigo');
        $retiradaLotes = collect($request->input('lotes_retirada'));
        // dd($retiradaLotes);


        // 1. Cria o registro de retirada no banco de dados.   
        $novaRetirada = Retiradas::create([
            'id_funcionarioFK' => 1,
            'id_postoFK' => $idRetiradaPosto,
            'cod_saida' => $codigoRetirada,
            'status' => 'Pendente',
            'data_saida' => now(),
        ]);
        // dd($novaRetirada);

        // dd($novaRetirada->id_retirada);
        foreach ($retiradaLotes as $dadosLote) {
            // 2. Insere os itens da retirada.
            $novoItem = Itens_retirados::create([
                'id_retiradaFK' => $novaRetirada->id_retirada,
                'id_medicamentoFK' => $dadosLote['idMedicamento'],
                'qtt_saida' => $dadosLote['saldoUsadoParaRetirada'],
                'lote' => $dadosLote['lote'],
            ]);
            // dd($novoItem);
        }

        // 3. Retorna o código único em formato JSON para o JavaScript.
        return response()->json([
            'status' => 'aprovado',
            'message' => 'Solicitação enviada com sucesso!',
            'codigo' => $codigoRetirada,
        ]);
    }

    public function selecionaPosto(Request $request)
    {
        $retiradaPosto = $request->input('idPosto');
        $nomePosto = Postos_saude::find($retiradaPosto)->nome;
        $retiradaLotes = collect($request->input('lotes_retirada'))->flatten(1);

        // Gera um código de saída único.
        $codUnico = '#' . strtoupper(Str::random(6));
        // dd($codUnico);  

        // 2. Extrai os IDs únicos de medicamentos para buscar no banco (Otimização!)
        $idsUnicos = $retiradaLotes->pluck('idMedicamento')->unique();

        // 3. Busca todos os nomes de medicamentos de uma vez e cria um mapa [id => nome]
        $medicamentosMap = Medicamento::whereIn('id_medicamento', $idsUnicos)
            ->pluck('nome', 'id_medicamento'); // Pluck com 2 argumentos cria o array associativo

        // 4. Usa o map() para adicionar o nome a cada item da coleção
        $dataLotes = $retiradaLotes->map(function ($dadosLote) use ($medicamentosMap) {

            $idMedicamento = $dadosLote['idMedicamento'];

            // Adiciona o novo campo 'nome_medicamento'
            // Usa o get() do Collection para buscar o nome ou retorna 'Desconhecido'
            $dadosLote['nomeMedicamento'] = $medicamentosMap->get($idMedicamento, 'Desconhecido');

            // Retorna o array modificado, que agora tem o nome
            return $dadosLote;
        });

        // A partir daqui, você usa a coleção $lotesComNomes
        // dd($lotesComNomes);

        return view('confirmarRetirada', [
            'idPosto' => $retiradaPosto,
            'nomePosto' => $nomePosto,
            'lotes' => $dataLotes,
            'codigo' => $codUnico,
        ]);
    }
}
