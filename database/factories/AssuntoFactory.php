<?php

namespace Database\Factories;

use App\Models\Assunto;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssuntoFactory extends Factory
{
    /**
     * O nome do modelo associado à fábrica.
     *
     * @var string
     */
    protected $model = Assunto::class;

    /**
     * Defina o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'str_descricao' => $this->faker->name(), // Gerar um nome aleatório
        ];
    }
}
