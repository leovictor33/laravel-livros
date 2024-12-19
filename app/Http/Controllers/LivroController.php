<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsável por gerir as operações relacionadas aos livros.
 */
class LivroController extends Controller
{
    /**
     * Recupera uma lista de livros ordenada pelo título em ordem crescente
     *    e retorna a visualização do índice de livros com os dados.
     *
     * @return Factory|View|Application|RedirectResponse
     */
    public function index()
    {
        try {
            $livros = Livro::orderBy('str_titulo', 'asc')->get();
            return view($this->getPathView(), compact('livros'));
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    /**
     * Exibe o formulário de criação de um novo livro.
     *
     * Este método prepara a visualização para adicionar um novo livro,
     * incluindo o carregamento de listas de autores e assuntos necessários para o formulário.
     * Em caso de erro, retorna uma resposta apropriada.
     *
     * @return Factory|View|Application|RedirectResponse
     */
    public function create()
    {
        try {
            $autores = Autor::orderBy('str_nome', 'asc')->get(); // Ordena os autores
            $assuntos = Assunto::orderBy('str_descricao', 'asc')->get(); // Ordena os assuntos

            return view($this->getPathView(), compact('autores', 'assuntos'));
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }

    /**
     * Salva um novo livro no banco de dados.
     *
     * Este método processa os dados enviados no formulário para criar um novo livro,
     * realizando a validação dos dados, formatação de campos, e associando autores e assuntos.
     * A resposta pode ser JSON ou um redirecionamento, dependendo da origem da requisição.
     *
     * @param Request $request Objeto da requisição HTTP contendo os dados do formulário.
     * @return JsonResponse|RedirectResponse Retorna resposta JSON para requisições de teste
     *                                       ou redireciona para a página de índice com mensagem de sucesso.
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        try {
            $arrData = $request->all();
            $arrData = $this->formatFields($arrData);

            $livro = Livro::create([
                'str_titulo'         => $arrData['str_titulo'],
                'str_editora'        => $arrData['str_editora'],
                'num_edicao'         => $arrData['num_edicao'],
                'num_ano_publicacao' => $arrData['num_ano_publicacao'],
                'num_valor'          => $arrData['num_valor'],
            ]);

            // Associando autores
            $livro->autores()->attach($request->autores);

            // Associando assuntos
            $livro->assuntos()->attach($request->assuntos);

            // Verifica se é uma requisição de teste
            if ($request->header('X-Test-Origin') === 'true') {
                return response()->json($livro, Response::HTTP_CREATED);
            }

            // Redireciona no uso Web normal
            return redirect()->route($this->getPathView())->with('success', 'Livro criado com sucesso!');
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    /**
     * Mostra os detalhes de um livro específico.
     *
     * Este método tenta buscar um livro pelo ID fornecido, incluindo os autores e assuntos relacionados.
     * Se o livro for encontrado, retorna uma visualização com os detalhes. Caso contrário, ou em caso
     * de outra exceção, retorna uma mensagem de erro tratada pelo método handleException.
     *
     * @param int $id ID do livro a ser exibido.
     * @return Factory|View|Application|RedirectResponse Retorna a página de detalhes do livro ou uma mensagem de erro.
     */
    public function show($id)
    {
        try {
            $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);

            return view($this->getPathView(), compact('livro'));
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    public function edit($id)
    {
        try {
            // Busca o livro pelo ‘ID’
            $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);

            // Busca listas adicionais (se necessário) para popular selects
            $autores = Autor::all();
            $assuntos = Assunto::all();

            // Retorna a view com os dados do livro
            return view($this->getPathView(), compact('livro', 'autores', 'assuntos'));
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    /**
     * Atualiza os dados de um livro específico.
     *
     * Este método permite atualizar informações de um livro existente no banco de dados,
     * como título, editora, edição, ano de publicação e valor. Também realiza a sincronização
     * dos autores e assuntos relacionados ao livro.
     *
     * @param Request $request Objeto contendo os dados enviados na requisição HTTP.
     * @param int $id ID do livro a ser atualizado.
     * @return RedirectResponse Redireciona para a página de índice com mensagem de sucesso.
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        try {
            $livro = Livro::findOrFail($id);

            $arrData = $request->all();
            $arrData = $this->formatFields($arrData);

            $livro->update([
                'str_titulo'         => $arrData['str_titulo'],
                'str_editora'        => $arrData['str_editora'],
                'num_edicao'         => $arrData['num_edicao'],
                'num_ano_publicacao' => $arrData['num_ano_publicacao'],
                'num_valor'          => $arrData['num_valor'],
            ]);

            // Atualizar relacionamentos
            $livro->autores()->sync($request->input('autores', []));
            $livro->assuntos()->sync($request->input('assuntos', []));

            // Redirecionar com mensagem de sucesso
            return redirect()->route($this->getPathView())->with('success', 'Livro atualizado com sucesso!');
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    /**
     * Remove um livro específico do banco de dados.
     *
     * Este método localiza um livro pelo seu ID e o remove do sistema. Caso o ID seja inválido ou haja
     * erro durante a exclusão, uma exceção é capturada e tratada adequadamente.
     *
     * @param int $id ID do livro a ser removido.
     * @return RedirectResponse Redireciona para a página de índice com mensagem de sucesso ou erro.
     */
    public function destroy($id)
    {
        try {
            $livro = Livro::findOrFail($id);
            $livro->delete();

            return redirect()->route($this->getPathView())->with('success', 'Livro excluído com sucesso!');
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }


    /**
     * Formata os campos específicos de entrada no padrão esperado.
     *
     * Este método aplica conversões e ajustes necessários nos dados de entrada.
     * Atualmente, o método ajusta o campo `num_valor` para o formato numérico
     * correto, substituindo vírgulas por pontos e removendo os pontos
     * como separadores de milhar.
     *
     * @param array $arrData Dados de entrada que serão formatados.
     * @return array Retorna os dados formatados com os ajustes aplicados.
     */
    private function formatFields(array $arrData)
    {
        if (isset($arrData['num_valor'])) {
            $arrData['num_valor'] = str_replace(',', '.',
                str_replace('.', '', $arrData['num_valor']));
        }

        return $arrData;
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
     * @return \Illuminate\Http\Response|RedirectResponse Retorna o PDF gerado com sucesso para
     * download ou uma resposta de erro caso ocorra uma exceção.
     */
    public function gerarRelatorioLivrosPorAutor(Autor $autor)
    {
        try {
            $livros = $autor->livros()->with(['autores', 'assuntos'])->get();

            $pdf = SnappyPdf::loadView('relatorios.livros_por_autor', compact('livros', 'autor'))
                ->setOption('enable-local-file-access', true)
                ->setPaper('a4', 'portrait'); // Definindo o tamanho e orientação do papel

            return $pdf->download('livros_por_' . $autor->str_nome . '.pdf');
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
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
        return [
            'str_titulo'         => 'required|string|max:40',
            'str_editora'        => 'required|string|max:40',
            'num_edicao'         => 'required|integer',
            'num_ano_publicacao' => 'required|integer|min:1900|max:' . date('Y'),
            'autores'            => 'array',
            'assuntos'           => 'array',
        ];
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
        return [
            'num_ano_publicacao.required' => 'O campo Ano de Publicação é obrigatório.',
            'num_ano_publicacao.integer'  => 'O Ano de Publicação deve ser um número inteiro.',
            'num_ano_publicacao.min'      => 'O Ano de Publicação deve ser no mínimo 1900.',
            'num_ano_publicacao.max'      => 'O Ano de Publicação não pode ser maior que o ano atual.',
            'str_titulo.required'         => 'O campo Título é obrigatório.',
            'str_titulo.max'              => 'O campo Título deve conter no máximo 40 caracteres.',
            'str_editora.required'        => 'O campo Título é obrigatório.',
            'str_editora.max'             => 'O campo Título deve conter no máximo 40 caracteres.',
            'num_edicao.required'         => 'O campo Edição é obrigatório.',
        ];
    }
}
