<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        DB::table('medicamentos')->insert([
            ['nome' => 'Paracetamol 500mg', 'descricao' => 'Analgésico'],
            ['nome' => 'Nimesulida', 'descricao' => 'Anti inflamatório'],
            ['nome' => 'Dipirona 1g', 'descricao' => 'Analgésico'],
            ['nome' => 'Ibuprofeno', 'descricao' => 'Anti inflamatório'],
            ['nome' => 'Amoxicilina', 'descricao' => 'Antibióticos'],
            ['nome' => 'Mirtazapina', 'descricao' => 'Antidepressivos'],
            ['nome' => 'Paracetamol 700mg', 'descricao' => 'Analgésico'],
            ['nome' => 'Clonazepam 2mg', 'descricao' => 'Ansiolítico'],
            ['nome' => 'Losartana Potássica', 'descricao' => 'Anti-hipertensivo'],
            ['nome' => 'Metformina', 'descricao' => 'Antidiabético oral'],
        ]);
    }
}
