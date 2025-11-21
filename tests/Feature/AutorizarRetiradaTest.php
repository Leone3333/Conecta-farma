<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Retiradas;
use App\Models\Funcionario;
use App\Models\Postos_saude;

// CT004 Verificar se o sistema altera o status da retirada conforme a resposta do funcionário (Negada ou Aprovada) >>
class AutorizarRetiradaTest extends TestCase
{
    // Criar todas as tabelas vazias no bd temporario
    use RefreshDatabase;

    // Verifica se o sistema altera o status de uma retirada persistente no banco para Aprovada ou Negada
    public function testAlterarStatus(): void
    {
        // DADOS DO BD TEMPORARIO

        // Posto e funcionários válidos
        $posto = Postos_saude::factory()->create();

        // Cria uma retirada Pendente que será alterada
        $retiradaPendente = Retiradas::factory()->create([
            'id_postoFK' => $posto->id_posto,
            'cod_saida' => '#TESTE2',
            'status' => 'Pendente',
        ]);

        // ------------------------------------------------------------------

        // Dados para teste
        $novoStatus = 'Aprovada';
        $rota = '/autorizar';
        $mensagemErro = "O novo status $novoStatus não foi salvo no banco o status da retirada é $retiradaPendente->status";

        // Simulação da requisição HTTP via POST
        $request = $this->post($rota, [
            'retirada' => $retiradaPendente->id_retirada,
            'status' => $novoStatus,
        ]);

        // Verifica se a requisição foi bem sucedida 
        $request->assertStatus(302);

        // Dados para consultar na tabela retiradas o novo status    
        $dadosEsperados = [
            'id_retirada' => $retiradaPendente->id_retirada,
            'status' => $novoStatus,
        ];

        // Verifica se o banco de dados foi atualizado corretamente o status do id retirada correspondente
        $registroExiste = Retiradas::query()->where($dadosEsperados)->exists();
        $this->assertTrue($registroExiste, $mensagemErro);
    }
}
