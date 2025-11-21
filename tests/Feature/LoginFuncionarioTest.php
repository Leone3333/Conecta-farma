<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Postos_saude;
use App\Models\Funcionario;
use App\Models\Retiradas;
use App\Models\Medicamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

// CT003 <<Verificar a funcionalidade de login de funcionário >>
class LoginFuncionarioTest extends TestCase
{
    // Criar todas as tabelas vazias no bd temporario
    use RefreshDatabase;


    // Tratar a entrada de uma requisição com matrícula e senha corretas
    public function testEntradaFuncionarioCorreta(): void
    {
        // 1. PREPARAÇÃO (Criação de Massa de Dados)

        // Cria um posto válido
        $posto = Postos_saude::factory()->create();
        // Cria um funcionário e o associa ao posto
        $funcionario = Funcionario::factory()->create([
            'id_postoFK' => $posto->id_posto,
            'matricula' => '234567',
            'senha' => 'farma1'
        ]);
        
         // Cria medicamentos (o Controller chama Medicamento::all())
        $medicamentos = Medicamento::factory(3)->create();

        // IMPORTANTE: Cria uma retirada PENDENTE (para evitar o retorno '0retirada' e garantir a View)
        Retiradas::factory()->create([
            'id_postoFK' => $posto->id_posto,
            'status' => 'Pendente'
        ]);

        // Dados que simulam o formulário de entrada 
        $dadosForm = [
            'matricula' => $funcionario->matricula,
            'senha' => $funcionario->senha, // A senha não é criptografada para simplificar
        ];
        // -------------------------------------------------------------

        // Rota do formulario de login
        $rotaLogin = '/login';

        // 2.FORMULARIO Simular envio de formulario via POST
        
        // Envia a requisição http post simulando um funcionário logado
        $response = $this->post($rotaLogin, $dadosForm);
        //------------------------------------------------------------------------------ 
        
        // 3. VERIFICAÇÃO verificar se o controller encontrou o usuario no BD e criou a sessão (validou)

        // Espera um redirecionamento (200) apó a requisição completar seu ciclo
        // OBS nesse caso é 200 só porque o controller retorna uma view e não uma rota ou uri
        $response->assertStatus(200);   

        // Verifica se a View 'codigoRetirada' foi retornada
        $response->assertViewIs('codigoRetirada');

        // Verifica se a variável 'login' foi armazenada na sessão
        // OBS: valor deve ser o objeto Funcionario
        $response->assertSessionHas('login');

        // 3.1 Verifica se as variáveis foram passadas para a View
    
        $response->assertViewHas('posto', $posto); //posto do funcionario

        $response->assertViewHas('retiradas', function ($retiradas) {
            return $retiradas->isNotEmpty();
        }); // retiradas associdas ao posto do funcionários 
    }

    // Tratar a entrada de uma requisição com matrícula e senha incorretas
    public function testEntradaFuncionarioIncorreta(): void
    {
        // 1. PREPARAÇÃO (Criação de Massa de Dados)

        // Cria um posto válido
        $posto = Postos_saude::factory()->create();

        // Cria um funcionário e o associa ao posto
        $funcionario = Funcionario::factory()->create([
            'id_postoFK' => $posto->id_posto,
            'matricula' => '231669',
            'senha' => 'farma2'
        ]);
        
         // Cria medicamentos (o Controller chama Medicamento::all())
        $medicamentos = Medicamento::factory(3)->create();

        // IMPORTANTE: Cria uma retirada PENDENTE (para evitar o retorno '0retirada' e garantir a View)
        Retiradas::factory()->create([
            'id_postoFK' => $posto->id_posto,
            'status' => 'Pendente'
        ]);

       
        $matriculaFalha = "231669";
        $senhaFalha = "farma";

        // Dados que simulam o formulário de entrada 
        $dadosForm = [
            'matricula' => $matriculaFalha,
            'senha' => $senhaFalha, // A senha não é criptografada para simplificar
        ];
        // -------------------------------------------------------------

        // Rota do formulario de login
        $rotaLogin = '/login';

        // 2.FORMULARIO Simular envio de formulario via POST
        
        // Envia a requisição http post simulando um funcionário logado
        $response = $this->post($rotaLogin, $dadosForm);
        //------------------------------------------------------------------------------ 
        
        // 3. VERIFICAÇÃO verificar se o controller impediu o acesso do ususario e recarregou a página com mensagem de erro

        // Verifica se o controller recarregou a pagina de login
        $response->assertRedirect();

        // Verifica se a chave 'errologin' foi armazenada na sessão
        
        // Verifica se a chave 'errologin' foi armazenada na sessão
        $response->assertSessionHas('erroLogin');
        
        // Verifica se a chave 'login' não existe na sessão validando o bloqueio do funcionario
        $response->assertSessionMissing('login');
    }
}
