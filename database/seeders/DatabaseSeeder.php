<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PostoSaudeSeeder::class,
            FuncionarioSeeder::class,
            MedicamentoSeeder::class,
            EstoqueSeeder::class,
            RetiradaSeeder::class,
            ItensRetiradosSeeder::class,
        ]);
    }
}
