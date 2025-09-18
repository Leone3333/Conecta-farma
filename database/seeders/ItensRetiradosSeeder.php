<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItensRetiradosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('itens_retirados')->insert([
            ['id_retiradaFK' => 1, 'id_medicamentoFK' => 1, 'qtt_saida' => 10, 'lote' => 'L1234'],
            ['id_retiradaFK' => 2, 'id_medicamentoFK' => 2, 'qtt_saida' => 5, 'lote' => 'L5678'],
            ['id_retiradaFK' => 3, 'id_medicamentoFK' => 3, 'qtt_saida' => 15, 'lote' => 'L9012'],
            ['id_retiradaFK' => 4, 'id_medicamentoFK' => 4, 'qtt_saida' => 3, 'lote' => 'L3456'],
            ['id_retiradaFK' => 5, 'id_medicamentoFK' => 5, 'qtt_saida' => 8, 'lote' => 'L7890'],
            ['id_retiradaFK' => 1, 'id_medicamentoFK' => 2, 'qtt_saida' => 7, 'lote' => 'L5678'],
            ['id_retiradaFK' => 2, 'id_medicamentoFK' => 4, 'qtt_saida' => 12, 'lote' => 'L3456'],
            ['id_retiradaFK' => 3, 'id_medicamentoFK' => 5, 'qtt_saida' => 4, 'lote' => 'L7890'],
            ['id_retiradaFK' => 4, 'id_medicamentoFK' => 1, 'qtt_saida' => 9, 'lote' => 'L1234'],
            ['id_retiradaFK' => 5, 'id_medicamentoFK' => 3, 'qtt_saida' => 11, 'lote' => 'L9012'],
        ]);
    }
}
