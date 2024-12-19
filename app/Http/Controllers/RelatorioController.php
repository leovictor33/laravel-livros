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
            $autores = Autor::with('livros')->orderBy('str_nome')->get();

            $pdf = SnappyPdf::loadView($this->getPathView(), compact('autores'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait');

            return $pdf->download('relatorio_livros.pdf');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao gerar o relatório de livros.');
        }
    }

    /**
     * Gera um relatório em PDF associado a um tema (assunto) específico.
     *
     * @param Assunto $assunto Objeto do modelo Assunto, representando os assuntos cujos livros serão listados no relatório.
     * @return RedirectResponse|Response O arquivo PDF gerado para download ou uma mensagem de erro.
     */
    public function porAssunto(Assunto $assunto)
    {
        try {
            $livros = DB::table('livros_por_assunto')
                ->where('assunto_id', $assunto->codigo)
                ->get();
            $strDescricao = $assunto->str_descricao;

            $pdf = SnappyPdf::loadView($this->getPathView(), compact('livros', 'strDescricao'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait');

            return $pdf->download('Livros_sobre_' . $strDescricao . '.pdf');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao gerar o relatório por assunto.', 'relatorios.erro');
        }
    }

    /**
     * Gera um relatório em PDF contendo os livros relacionados a um autor específico.
     *
     * Este método utiliza o autor fornecido como parâmetro para buscar todos os livros associados,
     * carregando também os relacionamentos de autores e assuntos dos livros. A partir desses dados,
     * um arquivo PDF é gerado com a ajuda da biblioteca SnappyPDF. O PDF é então enviado para download
     * com o nome do arquivo baseado no nome do autor.
     *
     * @param Autor $autor Objeto do modelo Autor, representando o autor cujos livros serão listados no relatório.
     * @return Response|RedirectResponse Retorna o PDF gerado com sucesso para
     * download ou uma resposta de erro caso ocorra uma exceção.
     */
    public function porAutor(Autor $autor)
    {
        try {
            $livros = $autor->livros()->with(['autores', 'assuntos'])->get();

            $pdf = SnappyPdf::loadView($this->getPathView(), compact('livros', 'autor'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait'); // Definindo o tamanho e orientação do papel

            return $pdf->download('livros_por_' . $autor->str_nome . '.pdf');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao gerar o relatório por autor.', 'relatorios.erro');
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
