<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Estoque;
use App\Models\Postos_saude;
use App\Models\Medicamento;
use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

// CT005 Verificar se o sistema salva no banco de dados, uma nova entrada de um medicamento no estoque do posto associado ao funcionário logado
class AdicionarEntradaMedTest extends TestCase
{
    // Criar todas as tabelas vazias no bd temporario
    use RefreshDatabase;

    //Verifica interação entre a requisição e adição correta de um medicamento no estoque 
    public function testAdicionarEntradaComSucesso(): void
    {
        // 1. PREPARAÇÃO (Criação de Massa de Dados)

        // Cria um posto válido
        $posto = Postos_saude::factory()->create();

        // Cria um funcionário e o associa ao posto
        $funcionario = Funcionario::factory()->create(['id_postoFK' => $posto->id_posto]);

        // Cria um medicamento (que será adicionado ao estoque)
        $medicamento = Medicamento::factory()->create();

        // Dados que simulam o formulário de entrada 
        // OBS O ID POSTO_FK DEVE VIM DO FUNCIONÁRIO LOGADO, POR ISSO O FORM NÃO ENVIA ISSO
        $dadosForm = [
            'id_medicamento_selecionado' => $medicamento->id_medicamento,
            'quantidade' => 50,
            'lote' => 'L3352',
            // O id_postoFK deve vir do funcionário logado ($posto->id_posto)
            // A data de entrada deve ser adicionada no controller
        ];

        // ---------------------------------------------------------------------------

        // Rota de adicionar registro no estoque
        $rotaAdicionar = '/adicionar';

        // 2.FORMULARIO Simular envio de formulario via POST

        // Envia a requisição http post simulando um funcionário logado
        $response = $this->withSession(['login' => $funcionario])->post($rotaAdicionar, $dadosForm);

        //------------------------------------------------------------------------------ 
        // 3. VERIFICAÇÃO verificar se o controller adicionou corretamente os dados do formulario no BD

        // Espera um redirecionamento (302) apó a requisição completar seu ciclo
        $response->assertStatus(302);

        // Cria um array com todos os dados esperados dentro do banco de dados depois de passar pelo controller 
        $dadosBD = [
            'id_postoFK' => $posto->id_posto,
            'id_medicamentoFK' => $medicamento->id_medicamento,
            'qtt_entrada' => 50,
            'lote' => 'L3352',
            'data_entrada' => now()->addYears()->format('Y-m-d H:i'),
        ];

        // Verifica se o registro de entrada de medicamento associado ao posto do funcionário logado foi adicionado corretamente no banco
        $registroExiste = Estoque::query()->where($dadosBD)->exists();
        $this->assertTrue($registroExiste, "O registro de entrada de medicamento não foi inserido corretamente no estoque.");
    }

    // Verifica interação entre a requisição e e o controller quando o funcionário não esta logado 
    public function testAdicionarEntradaSemSucesso(): void
    {
        // 1. PREPARAÇÃO (Criação de Massa de Dados)

        $posto = Postos_saude::factory()->create();
        $medicamento = Medicamento::factory()->create();

        // Dados que simulam o formulário de entrada 
        // OBS O ID POSTO_FK DEVE VIM DO FUNCIONÁRIO LOGADO, POR ISSO O FORM NÃO ENVIA ISSO
        $dadosForm = [
            'id_medicamento_selecionado' => $medicamento->id_medicamento,
            'quantidade' => 50,
            'lote' => 'L3352',
        ];

        // ---------------------------------------------------------------------------

        // Rota de adicionar registro no estoque
        $rotaAdicionar = '/adicionar';

        // 2.FORMULARIO Simular envio de formulario via POST

        // Envia a requisição http post sem funcionário logado
        $response = $this->post($rotaAdicionar, $dadosForm);

        //------------------------------------------------------------------------------ 
        
        // 3. VERIFICAÇÃO verificar se o controller redirecionou a requisição sem funcionário logado
        // Cria um array com todos os dados esperados dentro do banco de dados depois de passar pelo controller 
        $dadosBD = [
            'id_postoFK' => $posto->id_posto,
            'id_medicamentoFK' => $medicamento->id_medicamento,
            'qtt_entrada' => 50,
            'lote' => 'L3352',
            'data_entrada' => now()->addYears()->format('Y-m-d H:i'),
        ];
        
        // Verifica se o registro de entrada de medicamento NÃO foi adicionado corretamente no banco,
        //  pois o funcionário não esta logado
        $registroExiste = Estoque::query()->where($dadosBD)->exists();
        $this->assertFalse($registroExiste, "O registro de entrada foi inserido no estoque mesmo sem login.");
        
        // Espera um redirecionamento (302) apó a requisição completar seu ciclo
        $response->assertStatus(302);
        
        // Espera que, sem o um funcionario autenticado redirecione para a tela de login
        $response->assertRedirect('/login');
        
        // verifica se uma chave de erro foi atribuida neste redirecionamento
        $response->assertSessionHas('erroLogin');
    }

}
