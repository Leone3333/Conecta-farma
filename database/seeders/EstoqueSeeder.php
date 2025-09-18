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
            ['id_postoFK' => 1, 'id_medicamentoFK' => 1, 'data_entrada' => now(), 'lote' => 'L1234', 'qtt_entrada' => 150],
            ['id_postoFK' => 1, 'id_medicamentoFK' => 2, 'data_entrada' => now(), 'lote' => 'L5678', 'qtt_entrada' => 85],
            ['id_postoFK' => 2, 'id_medicamentoFK' => 3, 'data_entrada' => now(), 'lote' => 'L9012', 'qtt_entrada' => 40],
            ['id_postoFK' => 1, 'id_medicamentoFK' => 4, 'data_entrada' => now(), 'lote' => 'L3456', 'qtt_entrada' => 200],
            ['id_postoFK' => 2, 'id_medicamentoFK' => 5, 'data_entrada' => now(), 'lote' => 'L7890', 'qtt_entrada' => 25],
        ]);
    }
}
