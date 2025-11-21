<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Retiradas;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetiradasExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_retiradas_pendentes_posto(): void
    {
        Retiradas::factory()->count(3)->create([
            'id_postoFK' => 3,
            'status' => 'Pendente',
        ]); 
        
        Retiradas::factory()->count(3)->create([
            'id_postoFK' => 3,
            'status' => 'Negada',
        ]); 

        $retiradas = Retiradas::where('status', 'Pendente')->where('id_postoFK',3)->get();

        $this->assertCount(3, $retiradas,'O número de retiradas retornadas não é 3.');
    }
}
