<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Autor;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Classe RelatorioController
 *
 * Este controlador é responsável por gerar relatórios em PDF para livros
 * e livros agrupados por assuntos (assuntos).
 * Utiliza o pacote SnappyPdf para criar os arquivos PDF.
 */
class RelatorioController extends Controller
{
    /**
     * Gera um arquivo PDF que inclui todos os autores e seus respectivos livros,
     * ordenados por nome em ordem alfabética.
     *
     * O relatório é gerado no formato A4, orientação retrato e com acesso a arquivos locais habilitado.
     *
     * @return RedirectResponse|Response Retorna o arquivo PDF para download
     * ou uma resposta indicando falha na geração do relatório.
     */
    public function livros()
    {
        try {
            $autores = Autor::with($this->getPathView())->orderBy('str_nome')->get();

            $pdf = SnappyPdf::loadView('relatorios.livros', compact('autores'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait');

            return $pdf->download('relatorio_livros.pdf');
        } catch (ModelNotFoundException $e) {
            return $this->handleException($e, 'Nenhum autor ou livro encontrado para gerar o relatório.');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao gerar o relatório de livros.');
        }
    }

    /**
     * Gera um relatório em PDF associado a um tema (assunto) específico.
     *
     * @param int $assuntoId O ‘ID’ do assunto para filtrar os livros.
     * @return RedirectResponse|Response O arquivo PDF gerado para download ou uma mensagem de erro.
     */
    public function gerarRelatorioPorAssunto($assuntoId)
    {
        try {
            $assunto = Assunto::findOrFail($assuntoId);

            $livros = DB::table('livros_por_assunto')
                ->where('assunto_id', $assuntoId)
                ->get();

            $strAssunto = $assunto->str_descricao;

            $pdf = SnappyPdf::loadView($this->getPathView(), compact('livros', 'strAssunto'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait');

            return $pdf->download('Livros_sobre_' . $strAssunto . '.pdf');
        } catch (ModelNotFoundException $e) {
            return $this->handleException($e, 'Assunto não encontrado para gerar o relatório.', 'relatorios.erro');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao gerar o relatório por assunto.', 'relatorios.erro');
        }
    }

    /**
     * Retorna as regras de validação para os dados de entrada do modelo.
     *
     * Define as restrições de validação aplicáveis, como obrigatoriedade, tipo de dado,
     * e limite de caracteres para os campos especificados.
     *
     * @return array Um array associativo contendo as regras de validação.
     */
    public function getValidatorInput(): array
    {
        return [];
    }

    /**
     * Retorna as mensagens de validação personalizadas para o processo de validação dos dados de entrada.
     *
     * Essa configuração específica mensagens de erro para campos específicos, como o campo "str_descricao",
     * limitando o seu tamanho máximo a 20 caracteres.
     *
     * @return array Um array associativo contendo os atributos e suas respectivas mensagens de validação.
     */
    public function getValidatorMessage(): array
    {
        return [];
    }
}
