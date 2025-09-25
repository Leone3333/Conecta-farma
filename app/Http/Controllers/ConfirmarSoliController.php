<?php

namespace App\Http\Controllers;



use App\Models\Retiradas;
use App\Models\Itens_retirados;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; 

class ConfirmarSoliController extends Controller
{
    //
    public function confirmar(Request $request)
    {

        $idPosto = $request->idPosto;

        $mediSolicitados = json_decode($request->solicitacao, true);

        $loteRetirada = $this->estoqueRecente($idPosto, $mediSolicitados);

        dd($loteRetirda);

         try {
        $validated = $request->validate([
            'id_postoFK' => 'required|exists:postos_saude,id_posto',
            'itens' => 'required|array',
            'itens.*.id_medicamentoFK' => 'required|exists:medicamentos,id_medicamento',
            'itens.*.qtt_saida' => 'required|integer|min:1',
            'itens.*.lote' => 'required|string|max:10',
        ]);
    } catch (ValidationException $e) {
        // Se a validação falhar, retorne os erros como JSON
        return response()->json([
            'status' => 'error',
            'message' => 'Erro de validação.',
            'errors' => $e->errors()
        ], 422); // O código 422 significa "Entidade Não Processável"
    }
        
        // Gera um código de saída único.
        $codUnico = '#' . strtoupper(Str::random(6));
        // dd($codUnico);  

        // 1. Cria o registro de retirada no banco de dados.
       
        $novaRetirada = Retiradas::create([
            'id_funcionarioFK' => 1,
            'id_postoFK' => $validated['id_postoFK'],
            'cod_saida' => $codUnico,
            'status' => 'Pendente',
            'data_saida' => now(),
        ]);
        // dd($novaRetirada);

        // 2. Insere os itens da retirada.
        $allItens = collect($validated['itens'])->map(function ($item) use ($novaRetirada) {
            return [
                'id_retiradaFK' => $novaRetirada->id_retirada,
                'id_medicamentoFK' => $item['id_medicamentoFK'],
                'qtt_saida' => $item['qtt_saida'],
                'lote' => $item['lote']
            ];
        })->all();

        Itens_retirados::insert($allItens);
        // dd($allItens);


        // 3. Retorna o código único em formato JSON para o JavaScript.
        return response()->json([
            'status' => 'aprovado',
            'message' => 'Solicitação enviada com sucesso!',
            'codigo' => $codUnico,
        ]);
    } 

    public function estoqueRecente($idPostoSoli, $idMedicametnos)
    {
        $dataAntiga = Estoque::select(
            DB::raw('MIN(data_entrada) as data_mais_antiga')

        )
        ->whereColumn('id_medicamentoFK', 'e.id_medicamentoFK')
        ->where('id_postoFK', $idPostoSoli)
        ->groupBy('id_medicamentoFK')
        ->toSql();

        $estoqueAntigo = Estoque::from('estoque as e')
        ->select('e.lote', 'e.data_entrada')
        ->where('id_postoFK', $idPostoSoli)
        ->whereIn('id_medicamentoFK', $idMedicametnos)
        ->whereRaw("e.data_entrada IN ({$dataAntiga})")
        ->orderBy('e.data_entrada', 'asc')
        ->get();

         return $estoqueAntigo;
    }
}
