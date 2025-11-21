<?php

namespace Database\Factories;

use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionario>
 */
class FuncionarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Funcionario::class;
    public function definition(): array
    {
        return [
            // Defina valores padrão válidos e aleatórios para campos obrigatórios
            'id_postoFK' => \App\Models\Postos_saude::factory(), 
            'matricula' => $this->faker->unique()->numerify('######'),
            
            // Usa numerify() para garantir que a senha seja uma string de 6 dígitos
            'senha' => $this->faker->numerify('######')
        ];
    }
}
