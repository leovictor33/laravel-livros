<?php

namespace Database\Factories;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutorFactory extends Factory
{
    /**
     * O nome do modelo associado à fábrica.
     *
     * @var string
     */
    protected $model = Autor::class;

    /**
     * Defina o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'str_nome' => $this->faker->name(), // Gerar um nome aleatório
        ];
    }
}
