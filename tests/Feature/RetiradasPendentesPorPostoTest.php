<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Retiradas;
use App\Models\Postos_saude;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

// CT002 Validar funcionalidade de consultar retiradas pendentes associadas a um posto
class RetiradasPendentesPorPostoTest extends TestCase
{
    // Criar todas as tabelas vazias no bd temporario
    use RefreshDatabase;

    // Verificar a quantidade esperada do retorno das retiradas pendentes associadas a 1 id posto
    public function testQttPendetes(): void
    {

        // Postos validos 
        Postos_saude::factory()->count(3)->create();

        // dados de teste
        $idPostoTeste = 3;

        // Retiradas do ID Posto 3
        Retiradas::factory()->count(2)->create([
            'id_postoFK' => $idPostoTeste,
            'status' => 'Pendente',
        ]); 
        
        Retiradas::factory()->count(2)->create([
            'id_postoFK' => $idPostoTeste,
            'status' => 'Negada',
        ]); 
        
        // Retiradas do ID Posto 2
        Retiradas::factory()->count(1)->create([
            'id_postoFK' => 2,
            'status' => 'Pendente',
        ]); 
        
        Retiradas::factory()->count(1)->create([
            'id_postoFK' => 2,
            'status' => 'Negada',
        ]); 
        // ------------------------------------------------

        // A quantidade esperada é 2 retiradas pendentes no idPosto 3
        $retiradasPosto3 = Retiradas::pendentesPorPosto($idPostoTeste);
        $this->assertCount(2, $retiradasPosto3,'O número de retiradas retornadas não é 2.');
    }

    // Verificar se o sistema retorna os dados de todas as retiradas pendentes associadas a 1 id posto
    public function testDataRetiradaspendentes(): void
    {
        // dados de teste
        $idPostoTeste = 1;

        // Retiradas do ID Posto 3
        Retiradas::factory()->count(1)->create([
            'id_postoFK' => $idPostoTeste,
            'status' => 'Pendente',
            'cod_saida' => '#AE5RRG',
        ]); 
        
        Retiradas::factory()->count(1)->create([
            'id_postoFK' => $idPostoTeste,
            'status' => 'Pendente',
            'cod_saida' => '#125FNP',
        ]); 
        // ------------------------------------------------

        $retiradasPosto3 = Retiradas::pendentesPorPosto($idPostoTeste);
      
        $this->assertSame('#AE5RRG', $retiradasPosto3[0]->cod_saida,
         "O teste falhou porque o " . $retiradasPosto3[0]->cod_saida . " não corresponde  ao banco");
        
        $this->assertSame('#125FNP', $retiradasPosto3[1]->cod_saida,
        "O teste falhou porque o " . $retiradasPosto3[0]->cod_saida . " não corresponde  ao banco");
    }
}
