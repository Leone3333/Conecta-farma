<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetiradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('retiradas')->insert([
            ['id_funcionarioFK' => 1, 'id_postoFK' => 1, 'cod_saida' => '#AB123C', 'data_saida' => now(), 'status' => 'Pendente'],
            ['id_funcionarioFK' => 2, 'id_postoFK' => 2, 'cod_saida' => '#GH456L', 'data_saida' => now(), 'status' => 'Pendente'],
            ['id_funcionarioFK' => 1, 'id_postoFK' => 1, 'cod_saida' => '#PO789Q', 'data_saida' => now(), 'status' => 'Pendente'],
            ['id_funcionarioFK' => 3, 'id_postoFK' => 2, 'cod_saida' => '#RS101T', 'data_saida' => now(), 'status' => 'Pendente'],
            ['id_funcionarioFK' => 2, 'id_postoFK' => 1, 'cod_saida' => '#UV232W', 'data_saida' => now(), 'status' => 'Pendente'],
        ]);
    }
}
