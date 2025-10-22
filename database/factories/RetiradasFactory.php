<?php

namespace Database\Factories;

use App\Models\Retiradas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Retiradas>
 */
class RetiradasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            // Defina valores padrão válidos e aleatórios para campos obrigatórios
            'id_postoFK' => \App\Models\Postos_saude::factory(), // Cria um PostoSaude se não existir
            'id_funcionarioFK' => \App\Models\Funcionario::factory(), // Cria um Funcionário
            'data_saida' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'cod_saida' => '#'. $this->faker->unique()->randomNumber(6),
            'status' => $this->faker->randomElement(['Pendente', 'Concluído', 'Cancelado']),
        ];
    }
}
