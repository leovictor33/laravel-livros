<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function criar_autor()
    {
        $data = [
            'str_nome'         => 'Novo Autor',
        ];

        $response = $this->post(route('autores.store'), $data, ['X-Test-Origin' => 'true']);

        $response->assertStatus(201); // Esperando 201
        $this->assertDatabaseHas('tb_autor', ['str_nome' => 'Novo Autor']);
    }
}
