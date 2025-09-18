<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        DB::table('funcionarios')->insert([
            ['id_postoFK' => 1, 'matricula' => 345968, 'senha' => 'farma0'],
            ['id_postoFK' => 1, 'matricula' => 347169, 'senha' => 'farma1'],
            ['id_postoFK' => 2, 'matricula' => 341348, 'senha' => 'farma2'],
            ['id_postoFK' => 3, 'matricula' => 341198, 'senha' => 'farma3'],
            ['id_postoFK' => 4, 'matricula' => 344427, 'senha' => 'farma4'],
        ]);
    }
}
