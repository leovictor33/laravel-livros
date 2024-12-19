<?php

namespace Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssuntoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function criar_assunto()
    {
        $data = [
            'str_descricao' => 'Novo Assunto',
        ];

        $response = $this->post(route('assuntos.store'), $data, ['X-Test-Origin' => 'true']);

        $response->assertStatus(201); // Esperando 201
        $this->assertDatabaseHas('tb_assunto', ['str_descricao' => 'Novo Assunto']);
    }
}
