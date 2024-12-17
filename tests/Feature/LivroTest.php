<?php

namespace Tests\Feature;

use App\Models\Assunto;
use Tests\TestCase;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function criar_livro()
    {
        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        $data = [
            'str_titulo'         => 'Novo Livro',
            'str_editora'        => 'Editora Exemplo',
            'num_edicao'         => random_int(1, 100),
            'num_ano_publicacao' => 2024,
            'num_valor'          => 99.99,
            'autores'            => [$autor->codigo], // Corrigido para passar apenas o ID
            'assuntos'           => [$assunto->codigo], // Corrigido para passar apenas o ID
        ];

        $response = $this->post(route('livros.store'), $data, ['X-Test-Origin' => 'true']);

        $response->assertStatus(201); // Esperando 201
        $this->assertDatabaseHas('tb_livro', ['str_titulo' => 'Novo Livro']);
    }
}
