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
            // Retirada 1 (Posto 1)
            ['id_retiradaFK' => 1, 'id_medicamentoFK' => 1, 'qtt_saida' => 10, 'lote' => 'L1234'],
            ['id_retiradaFK' => 1, 'id_medicamentoFK' => 2, 'qtt_saida' => 5, 'lote' => 'L5666'],

            // Retirada 2 (Posto 2)
            ['id_retiradaFK' => 2, 'id_medicamentoFK' => 2, 'qtt_saida' => 15, 'lote' => 'L3456'],

            // Retirada 3 (Posto 1)
            ['id_retiradaFK' => 3, 'id_medicamentoFK' => 1, 'qtt_saida' => 20, 'lote' => 'L1234'],

            // Retirada 4 (Posto 2)
            ['id_retiradaFK' => 4, 'id_medicamentoFK' => 2, 'qtt_saida' => 10, 'lote' => 'L3456'],

            // Retirada 5 (Posto 1)
            ['id_retiradaFK' => 5, 'id_medicamentoFK' => 3, 'qtt_saida' => 5, 'lote' => 'L0988'],
        ]);
    }
}
