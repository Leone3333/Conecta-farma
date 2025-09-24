<?php

namespace App\Http\Controllers;



use App\Models\Retiradas;
use App\Models\Itens_retirados;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; 

class ConfirmarSoliController extends Controller
{
    //
    public function confirmar(Request $request)
    {

        // dd($request->all());
         try {
        $validated = $request->validate([
            'id_funcionarioFK' => 'required',
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
            'id_funcionarioFK' => $validated['id_funcionarioFK'],
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
}
