<?php

namespace Feature;

use App\Models\Assunto;
use App\Models\Autor;
use Tests\TestCase;

class RelatorioControllerTest extends TestCase
{
    protected $livro = [];
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }
    /** @test */
    public function it_generates_pdf_for_livros_report()
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

        $this->post(route('livros.store'), $data, ['X-Test-Origin' => 'true']);

        // Simula a requisição para gerar o relatório de livros
        $response = $this->get(route('relatorios.livros'));

        // Verifica se o tipo de conteúdo da resposta é PDF
        $response->assertHeader('Content-Type', 'application/pdf');

        // Verifica se o PDF foi gerado e retornado
        $response->assertStatus(200);
    }
    public function it_generates_pdf_for_assunto_report()
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

        $this->post(route('livros.store'), $data, ['X-Test-Origin' => 'true']);

        // Simula a requisição para gerar o relatório de livros
        $response = $this->get(route('relatorios.assunto', $assunto->codigo));

        // Verifica se o tipo de conteúdo da resposta é PDF
        $response->assertHeader('Content-Type', 'application/pdf');

        // Verifica se o PDF foi gerado e retornado
        $response->assertStatus(200);
    }
    public function it_generates_pdf_for_autor_report()
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

        $this->post(route('livros.store'), $data, ['X-Test-Origin' => 'true']);

        // Simula a requisição para gerar o relatório de livros
        $response = $this->get(route('relatorios.autor', $autor->codigo));

        // Verifica se o tipo de conteúdo da resposta é PDF
        $response->assertHeader('Content-Type', 'application/pdf');

        // Verifica se o PDF foi gerado e retornado
        $response->assertStatus(200);
    }
}
