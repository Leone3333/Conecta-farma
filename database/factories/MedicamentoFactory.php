<?php

namespace Database\Factories;

use App\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicamento>
 */
class MedicamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        return [
            // Campo 'nome'
            'nome' => $this->faker->unique()->word() . ' ' . $this->faker->randomElement(['25mg', '500mg', '100ml']),

            // Campo 'descricao'
            'descricao' => $this->faker->sentence(5),
        ];
    }
}
