<?php

namespace Database\Factories;

use App\Models\Postos_saude;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postos_saude>
 */
class PostosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Postos_saude::class;
    public function definition(): array
    {
        return [
            // Defina valores padrão válidos e aleatórios para campos obrigatórios
            'nome' => $this->faker->company(), // Cria um PostoSaude se não existir
            'endereco' => $this->faker->address(),
            'telefone' => $this->faker->phoneNumber()
        ];
    }
}
