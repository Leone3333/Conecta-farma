<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostoSaudeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        DB::table('postos_saude')->insert([
            ['nome' => 'UBS SAO GONCALO', 'endereco' => 'AVENIDA CARDEAL DA SILVA - 789, FEDERACAO', 'telefone' => '(71)3611-1340'],
            ['nome' => 'USF PROF EDUARDO MAMEDE', 'endereco' => 'SETOR E CAMINHO 16 - S/N, MUSSURUNGA I', 'telefone' => '(71) 36112962'],
            ['nome' => 'USF PARQUE SAO CRISTOVAO', 'endereco' => 'RUA RODOVIA A - S/N, BOA VISTA DE SAO CAE', 'telefone' => '(71) 3611-3543'],
            ['nome' => 'USF BOA VISTA DE SAO CAETANO', 'endereco' => 'RUA SANTA RITA DA CEASA - 1111, SAO CRISTOVAO', 'telefone' => '(71) 3611-7230'],
            ['nome' => 'UBS MINISTRO ALKIMIN', 'endereco' => 'RUA LOPES TROVAO - S/N, MASSARANDUBA', 'telefone' => '(71) 3611-6561'],
        ]);
    }
}
