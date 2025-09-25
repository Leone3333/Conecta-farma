<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstoqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estoque')->insert([
            // POSTO 1
            // Med 1: L1234 (FIFO) vs L5678
            ['id_postoFK' => 1, 'id_medicamentoFK' => 1, 'data_entrada' => '2025-01-01', 'lote' => 'L1234', 'qtt_entrada' => 80], // FIFO
            ['id_postoFK' => 1, 'id_medicamentoFK' => 1, 'data_entrada' => '2025-03-01', 'lote' => 'L5678', 'qtt_entrada' => 85],

            // Med 2: L5666
            ['id_postoFK' => 1, 'id_medicamentoFK' => 2, 'data_entrada' => '2025-04-01', 'lote' => 'L5666', 'qtt_entrada' => 40], // FIFO

            // Med 3: L0988
            ['id_postoFK' => 1, 'id_medicamentoFK' => 3, 'data_entrada' => '2025-05-01', 'lote' => 'L0988', 'qtt_entrada' => 15], // FIFO

            // POSTO 2
            // Med 1: L9012
            ['id_postoFK' => 2, 'id_medicamentoFK' => 1, 'data_entrada' => '2025-01-05', 'lote' => 'L9012', 'qtt_entrada' => 40], // FIFO

            // Med 2: L3456 (FIFO) vs L7890
            ['id_postoFK' => 2, 'id_medicamentoFK' => 2, 'data_entrada' => '2025-02-10', 'lote' => 'L3456', 'qtt_entrada' => 100], // FIFO
            ['id_postoFK' => 2, 'id_medicamentoFK' => 2, 'data_entrada' => '2025-04-15', 'lote' => 'L7890', 'qtt_entrada' => 25],
        ]);
    }
}
